<?php
  session_start();
  require("database.php");

  $queryMovies = 'SELECT * FROM movies';
  $statement1 = $db->prepare($queryMovies);
  $statement1->execute();
  $movies = $statement1->fetchAll();
  $statement1->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Manager - Home</title>
  <link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

  <body>
    <?php include("header.php"); ?>

    <main>
      <h2>Movie List</h2>

      <table>
        <tr>
          <th>Title</th>
          <th>Year</th>
          <th>Genre</th>
          <th>Director</th>
          <th>Duration</th>
          <th>Language</th>
          <th>Rating</th>
        </tr>
        <?php foreach ($movies as $movie): ?>
        <tr>
          <td><?php echo $movie['title']; ?></td>
          <td><?php echo $movie['year']; ?></td>
          <td><?php echo $movie['genre']; ?></td>
          <td><?php echo $movie['director']; ?></td>
          <td><?php echo $movie['duration']; ?></td>
          <td><?php echo $movie['language']; ?></td>
          <td><?php echo $movie['rating']; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </main>

    <?php include("footer.php"); ?>
  </body>
</html>