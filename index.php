<?php
  session_start();

  if (!isset($_SESSION["isLoggedIn"])) {
    header("Location: login_form.php");
    die();
  }

  require("database.php");

  $selected_genre = $_GET['genre'] ?? '';

  $queryGenres = 'SELECT * FROM genre ORDER BY genreName';
  $statementG = $db->prepare($queryGenres);
  $statementG->execute();
  $genres = $statementG->fetchAll();
  $statementG->closeCursor();

  $queryMovies = '
    SELECT m.*, g.genreName
    FROM movies m
    LEFT JOIN genre g ON m.genreID = g.genreID
  ';
  if (!empty($selected_genre)) {
    $queryMovies .= ' WHERE m.genreID = :genreID';
  }
  $queryMovies .= ' ORDER BY m.title';

  $statement1 = $db->prepare($queryMovies);

  if (!empty($selected_genre)) {
    $statement1->bindValue(':genreID', $selected_genre);
  }

  $statement1->execute();
  $movies = $statement1->fetchAll();
  $statement1->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Movie Manager - Home</title>
  <link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
  <?php include("header.php"); ?>

  <main>
    <h2>Movie List</h2>

    <form method="get" action="" class="genre-filter">
      <label for="genre">Filter by Genre:</label>
      <div class="select-wrapper">
        <select name="genre" id="genre" onchange="this.form.submit()">
          <option value="">-- All Genres --</option>
          <?php foreach ($genres as $genre): ?>
            <option value="<?= $genre['genreID'] ?>" <?= $selected_genre == $genre['genreID'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($genre['genreName']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </form>

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
        <th>Details</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($movies as $movie): ?>
        <tr>
          <td><?= htmlspecialchars($movie['title']) ?></td>
          <td><?= htmlspecialchars($movie['year']) ?></td>
          <td><?= htmlspecialchars($movie['genreName']) ?></td>
          <td><?= htmlspecialchars($movie['director']) ?></td>
          <td><?= htmlspecialchars($movie['duration']) ?></td>
          <td><?= htmlspecialchars($movie['language']) ?></td>
          <td><?= htmlspecialchars($movie['rating']) ?></td>
          <td>
            <img class="movie-photo" src="<?= htmlspecialchars('./images/' . $movie['imageName']) ?>"
                 alt="<?= htmlspecialchars($movie['title']) ?>" 
                 style="height: 100px;" />
          </td>
          <td>
            <form action="movie_detail.php" method="post">
              <input type="hidden" name="movie_id" value="<?= $movie['movieID'] ?>" />
              <input type="submit" value="Details" />
            </form>
          </td>
          <td>
            <form action="update_movie_form.php" method="post">
              <input type="hidden" name="movie_id" value="<?= $movie['movieID'] ?>" />
              <input type="submit" value="Update" />
            </form>
          </td>
          <td>
            <form action="delete_movie.php" method="post">
              <input type="hidden" name="movie_id" value="<?= $movie['movieID'] ?>" />
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