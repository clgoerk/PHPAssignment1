<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Movie Manager - Update Confirmation</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <?php include("header.php"); ?>

    <main>
      <h2>Movie Update Confirmation</h2>
      <p>Your movie was successfully saved. Please continue to add to your collection.</P>
      <p><a href="index.php" class="button-link" >View Movie List</a></p>
    </main>

    <?php include("footer.php"); ?>
  </body>
</html>