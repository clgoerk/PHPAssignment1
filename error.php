<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Movie Manager - Error</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <?php include("header.php"); ?>

    <main>
      <h2>Error</h2>
      <?php echo $_SESSION["add_error"]; ?> 
      </P>
      <p><a href="add_movie_form.php">Add Movie</a></p>
      <p><a href="index.php">View Movie List</a></p>
    </main>

    <?php include("footer.php"); ?>
  </body>
</html>