<?php
  require_once('database.php');

  // get the data from the form
  $movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);

  // code to delete contact from database
  // validate inputs
  if ($movie_id != false) {
    // delete the contact from the database
    $query = 'DELETE FROM movies WHERE movieID = :movie_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':movie_id', $movie_id);        

    $statement->execute();
    $statement->closeCursor();
  }

  // reload index page
  $url = "index.php";
  header("Location: " . $url);
  die();
?>