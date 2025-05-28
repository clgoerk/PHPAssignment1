<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'image_util.php'; // the process_image function

$image_dir = 'images';
$image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

if (isset($_FILES['file1'])) {
  $filename = $_FILES['file1']['name'];
  if (!empty($filename)) {
    $source = $_FILES['file1']['tmp_name'];
    $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
    move_uploaded_file($source, $target);

    // create the '400' and '100' versions of the image
    process_image($image_dir_path, $filename);
  }
}

// get data from the form
$title = filter_input(INPUT_POST, 'title');
$year = filter_input(INPUT_POST, 'year');
$genre = filter_input(INPUT_POST, 'genre');
$director = filter_input(INPUT_POST, 'director');
$duration = filter_input(INPUT_POST, 'duration'); // selected radio button
$language = filter_input(INPUT_POST, 'language');
$rating = filter_input(INPUT_POST, 'rating');
$image_name = $_FILES['file1']['name'];

require_once('database.php');
$queryMovies = 'SELECT * FROM movies';
$statement1 = $db->prepare($queryMovies);
$statement1->execute();
$movies = $statement1->fetchAll();
$statement1->closeCursor();

// Check for duplicate title and year
foreach ($movies as $movie) {
  if ($title === $movie['title'] && $year === $movie['year']) {
    $_SESSION["add_error"] = "Duplicate movie entry: '$title' ($year) already exists.";
    header("Location: error.php");
    die();
  }
}

// Validate required movie fields
if (
  $title == null || $year == null || $genre == null ||
  $director == null || $duration == null || $language == null || $rating == null
) {
  $_SESSION["add_error"] = "Invalid movie data, check all fields and try again.";
  header("Location: error.php");
  die();
} else {
  // Add the movie to the database
  $query = 'INSERT INTO movies
    (title, year, genre, director, duration, language, rating, imageName)
    VALUES
    (:title, :year, :genre, :director, :duration, :language, :rating, :imageName)';

  $statement = $db->prepare($query);
  $statement->bindValue(':title', $title);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':genre', $genre);
  $statement->bindValue(':director', $director);
  $statement->bindValue(':duration', $duration);
  $statement->bindValue(':language', $language);
  $statement->bindValue(':rating', $rating);
  $statement->bindValue(':imageName', $image_name);
  $statement->execute();
  $statement->closeCursor();
}

// redirect to confirmation page
$url = "confirmation.php";
header("Location: " . $url);
die();
?>