<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Movie Manager - Confirmation</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <?php include("header.php"); ?>

<main>
  <h2>Movie Confirmation</h2>
  <p>Your movie was successfully saved. Please continue to add to your collection.</p>
  <p><a href="index.php" class="button-link" >View Movies</a></p>
</main>

    <?php include("footer.php"); ?>
  </body>
</html>