<!DOCTYPE html>
<html>
  <head>
    <title>Movie Manager - Add Movie</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <?php include("header.php"); ?>

    <main>
      <h2>Add Movies</h2>

      <form action="add_movie.php" method="post" id="add_movie_form" enctype="multipart/form-data">
        <div id="data">
          <label>Title:</label>
          <input type="text" name="title" /><br />

          <label>Year:</label>
          <input type="date" name="year" /><br />

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
                echo "<option value=\"" . $g['genreID'] . "\">" . htmlspecialchars($g['genreName']) . "</option>";
              }
            ?>
          </select><br />

          <label>Director:</label>
          <input type="text" name="director" /><br />

          <label>Duration:</label>
          <input type="text" name="duration" /><br />

          <label>Language:</label>
          <input type="text" name="language" /><br />

          <label>Rating:</label>
          <input type="text" name="rating" /><br />

          <label>Upload Image:</label>
          <input type="file" name="file1" /><br />
        </div>

        <div id="buttons">
          <input type="submit" value="Save Movie" /><br />
        </div>
      </form>

      <p><a href="index.php" class="button-link">View Movie List</a></p>
    </main>

    <?php include("footer.php"); ?>
  </body>
</html>