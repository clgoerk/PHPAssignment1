<?php
  session_start();

  if (!isset($_SESSION["isLoggedIn"])) {
    header("Location: login_form.php");
    die();
  }

  require("database.php");

  $queryMovies = '
    SELECT m.*, g.genreName
    FROM movies m
    LEFT JOIN genre g ON m.genreID = g.genreID
  ';
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
        <th>Photo</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($movies as $movie): ?>
        <tr>
          <td><?php echo $movie['title']; ?></td>
          <td><?php echo $movie['year']; ?></td>
          <td><?php echo $movie['genreName']; ?></td>
          <td><?php echo $movie['director']; ?></td>
          <td><?php echo $movie['duration']; ?></td>
          <td><?php echo $movie['language']; ?></td>
          <td><?php echo $movie['rating']; ?></td>
          <td>
            <img class="movie-photo" src="<?php echo htmlspecialchars('./images/' . $movie['imageName']); ?>" 
                 alt="<?php echo htmlspecialchars($movie['title']); ?>" 
                 style="height: 100px;" />
          </td>
          <td>
            <form action="update_movie_form.php" method="post">
              <input type="hidden" name="movie_id" value="<?php echo $movie['movieID']; ?>" />
              <input type="submit" value="Update" />
            </form>
          </td>
          <td>
            <form action="delete_movie.php" method="post">
              <input type="hidden" name="movie_id" value="<?php echo $movie['movieID']; ?>" />
              <input type="submit" value="Delete" />
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <p><a href="add_movie_form.php" class="button-link">Add Movie</a></p>
    <p><a href="logout.php" class="button-link">Logout</a></p>
  </main>

  <?php include("footer.php"); ?>
</body>
</html>