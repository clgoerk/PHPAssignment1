<?php
session_start();

require_once('database.php');
require_once('image_util.php');

$movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);

// Get data from the form
$title = filter_input(INPUT_POST, 'title');
$year = filter_input(INPUT_POST, 'year');
$genre_id = filter_input(INPUT_POST, 'genreID', FILTER_VALIDATE_INT);
$director = filter_input(INPUT_POST, 'director');
$duration = filter_input(INPUT_POST, 'duration');
$language = filter_input(INPUT_POST, 'language');
$rating = filter_input(INPUT_POST, 'rating');
$image = $_FILES['file1'];

// Check for duplicate movie (excluding current movie)
$queryMovies = 'SELECT * FROM movies';
$statement1 = $db->prepare($queryMovies);
$statement1->execute();
$movies = $statement1->fetchAll();
$statement1->closeCursor();

foreach ($movies as $movie) {
  if ($title === $movie['title'] && $year === $movie['year'] && $movie_id != $movie['movieID']) {
    $_SESSION["add_error"] = "Duplicate movie entry: '$title' ($year) already exists.";
    header("Location: error.php");
    die();
  }
}

// Validate required fields
if (
  $title == null || $year == null || $genre_id == null ||
  $director == null || $duration == null || $language == null || $rating == null
) {
  $_SESSION["add_error"] = "Invalid movie data, check all fields and try again.";
  header("Location: error.php");
  die();
}

// Get current image from database
$query = 'SELECT imageName FROM movies WHERE movieID = :movieID';
$statement = $db->prepare($query);
$statement->bindValue(':movieID', $movie_id);
$statement->execute();
$current = $statement->fetch();
$current_image_name = $current['imageName'];
$statement->closeCursor();

$image_name = $current_image_name;
$base_dir = 'images/';

if ($image && $image['error'] === UPLOAD_ERR_OK) {
  // Remove old images
  if ($current_image_name) {
    $dot = strrpos($current_image_name, '_100.');
    if ($dot !== false) {
      $original_name = substr($current_image_name, 0, $dot) . substr($current_image_name, $dot + 4);
      $original = $base_dir . $original_name;
      $img_100 = $base_dir . $current_image_name;
      $img_400 = $base_dir . substr($current_image_name, 0, $dot) . '_400' . substr($current_image_name, $dot + 4);

      if (file_exists($original)) unlink($original);
      if (file_exists($img_100)) unlink($img_100);
      if (file_exists($img_400)) unlink($img_400);
    }
  }

  // Save and process new image
  $original_filename = basename($image['name']);
  $upload_path = $base_dir . $original_filename;
  move_uploaded_file($image['tmp_name'], $upload_path);
  process_image($base_dir, $original_filename);

  // Save the _100 image name
  $dot_position = strrpos($original_filename, '.');
  $name_without_ext = substr($original_filename, 0, $dot_position);
  $extension = substr($original_filename, $dot_position);
  $image_name = $name_without_ext . '_100' . $extension;
}

// Update movie
$query = 'UPDATE movies
  SET title = :title,
      year = :year,
      genreID = :genreID,
      director = :director,
      duration = :duration,
      language = :language,
      rating = :rating,
      imageName = :imageName
  WHERE movieID = :movieID';

$statement = $db->prepare($query);
$statement->bindValue(':title', $title);
$statement->bindValue(':year', $year);
$statement->bindValue(':genreID', $genre_id);
$statement->bindValue(':director', $director);
$statement->bindValue(':duration', $duration);
$statement->bindValue(':language', $language);
$statement->bindValue(':rating', $rating);
$statement->bindValue(':imageName', $image_name);
$statement->bindValue(':movieID', $movie_id);
$statement->execute();
$statement->closeCursor();

// Redirect
header("Location: update_confirmation.php");
die();
?>