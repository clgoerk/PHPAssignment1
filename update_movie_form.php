<?php
  require_once('database.php');

  // get the data from the form
  $movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);

  // select the contact from the database
  $query = 'SELECT * FROM movies WHERE movieID = :movie_id';
  $statement = $db->prepare($query);
  $statement->bindValue(':movie_id', $movie_id);        
  $statement->execute();
  $movie = $statement->fetch();
  $statement->closeCursor();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Movie Manager - Update Movie</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <?php include("header.php"); ?>

    <main>
      <h2>Update Movie</h2>

      <form action="update_movie.php" method="post" id="update_movie_form" enctype="multipart/form-data">
        <div id="data">
          <input type="hidden" name="movie_id" value="<?php echo $movie['movieID']; ?>" />

          <label>Title:</label>
          <input type="text" name="title" value="<?php echo $movie['title']; ?>" /><br />

          <label>Year:</label>
          <input type="date" name="year" value="<?php echo $movie['year']; ?>" /><br />

          <label>Genre:</label>
          <select name="genreID" required>
            <option value="">-- Select Genre --</option>
            <?php
              require_once("database.php");
              $query = "SELECT genreID, genreName FROM genre ORDER BY genreName";
              $statement = $db->prepare($query);
              $statement->execute();
              $genres = $statement->fetchAll();
              $statement->closeCursor();

              foreach ($genres as $g) {
                $selected = ($g['genreID'] == $movie['genreID']) ? 'selected' : '';
                echo "<option value=\"" . $g['genreID'] . "\" $selected>" . htmlspecialchars($g['genreName']) . "</option>";
              }
            ?>
          </select><br />

          <label>Director:</label>
          <input type="text" name="director" value="<?php echo $movie['director']; ?>" /><br />

          <label>Duration:</label>
          <input type="text" name="duration" value="<?php echo $movie['duration']; ?>" /><br />

          <label>Language:</label>
          <input type="text" name="language" value="<?php echo $movie['language']; ?>" /><br />

          <label>Rating:</label>
          <input type="text" name="rating" value="<?php echo $movie['rating']; ?>" /><br />

          <?php if (!empty($movie['imageName'])): ?>
            <label>Current Image:</label>
            <img src="images/<?php echo htmlspecialchars($movie['imageName']); ?>" height="100"><br />
          <?php endif; ?>

          <label>Update Image:</label>
          <input type="file" name="file1"><br />
        </div>

        <div id="buttons">
          <label>&nbsp;</label>
          <input type="submit" value="Update Movie" /><br />
        </div>
      </form>

      <p><a href="index.php" class="button-link">View Movie List</a></p>
    </main>

    <?php include("footer.php"); ?>
  </body>
</html>