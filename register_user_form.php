<?php
  require_once("database.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Movie Manager - Register</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <?php include("header.php"); ?>

    <main>
      <h2>Register</h2>
      
      <form action="register_user.php" method="post" id="register_user_form" autocomplete="off">
        <div id="data">
          <label for="user_name">User Name:</label>
          <input type="text" name="user_name" id="user_name" autocomplete="off" required />

          <label for="password">Password:</label>
          <input type="password" name="password" id="password" autocomplete="new-password" required />
        </div>

        <div id="buttons">
          <input type="submit" value="Register" />
        </div>
      </form>
    </main>

    <?php include("footer.php"); ?>
  </body>
</html>