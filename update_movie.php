<?php
session_start();

$movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);

// get data from the form
$title = filter_input(INPUT_POST, 'title');
$year = filter_input(INPUT_POST, 'year');
$genre = filter_input(INPUT_POST, 'genre');
$director = filter_input(INPUT_POST, 'director');
$duration = filter_input(INPUT_POST, 'duration');
$language = filter_input(INPUT_POST, 'language');
$rating = filter_input(INPUT_POST, 'rating');

require_once('database.php');
$queryMovies = 'SELECT * FROM movies';
$statement1 = $db->prepare($queryMovies);
$statement1->execute();
$movies = $statement1->fetchAll();
$statement1->closeCursor();

// Check for duplicate title and year (excluding current movie)
foreach ($movies as $movie) {
  if ($title === $movie['title'] && $year === $movie['year'] && $movie_id != $movie['movieID']) {
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
  // Update the movie in the database
  $query = 'UPDATE movies
    SET title = :title,
        year = :year,
        genre = :genre,
        director = :director,
        duration = :duration,
        language = :language,
        rating = :rating
    WHERE movieID = :movieID';

  $statement = $db->prepare($query);
  $statement->bindValue(':movieID', $movie_id);
  $statement->bindValue(':title', $title);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':genre', $genre);
  $statement->bindValue(':director', $director);
  $statement->bindValue(':duration', $duration);
  $statement->bindValue(':language', $language);
  $statement->bindValue(':rating', $rating);
  $statement->execute();
  $statement->closeCursor();
}

// Redirect to confirmation page
  $url = "update_confirmation.php";
  header("Location: " . $url);
  die();
?>