<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Movie Manager - Login</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
  </head>
  <body>
    <?php include("header.php"); ?>

    <main>
      <h2>Login</h2>

      <?php
        if (isset($_SESSION['lockout_remaining'])) {
          $remaining = (int)$_SESSION['lockout_remaining'];
          echo '<p id="countdown" data-remaining="' . $remaining . '" style="color: red; font-weight: bold;">Account locked. Please wait ' . $remaining . ' seconds.</p>';
          
          unset($_SESSION['login_error']);
          unset($_SESSION['lockout_remaining']);
        } elseif (isset($_SESSION['login_error'])) {
          echo '<p style="color: red; font-weight: bold;">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
          unset($_SESSION['login_error']);
        }
      ?>
      <br>
      <form action="login.php" method="post" id="login_form" autocomplete="off" enctype="multipart/form-data">
        <div id="data">
          <label for="user_name">User Name:</label>
          <input type="text" name="user_name" id="user_name" autocomplete="off" required />

          <label for="password">Password:</label>
          <input type="password" name="password" id="password" autocomplete="new-password" required />
        </div>

        <div id="buttons">
          <input type="submit" value="Login" />
        </div>
      </form>

      <p><a href="register_user_form.php" class="button-link">Register</a></p>
    </main>

    <?php include("footer.php"); ?>

    <script src="scripts/app.js"></script>
  </body>
</html>