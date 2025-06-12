<?php
session_start();
require_once("database.php");

// Get movie ID from POST
$movie_id = filter_input(INPUT_POST, 'movie_id', FILTER_VALIDATE_INT);
if (!$movie_id) {
    header("Location: index.php");
    exit;
}

// Fetch movie info including genre name
$query = '
  SELECT m.*, g.genreName 
  FROM movies m 
  LEFT JOIN genre g ON m.genreID = g.genreID 
  WHERE m.movieID = :movie_id
';
$statement = $db->prepare($query);
$statement->bindValue(':movie_id', $movie_id);
$statement->execute();
$movie = $statement->fetch();
$statement->closeCursor();

if (!$movie) {
    echo "Movie not found.";
    exit;
}

// Preserve extension and build _400 version
$imageName = $movie['imageName']; 
$dotPosition = strrpos($imageName, '.');
$baseName = substr($imageName, 0, $dotPosition);
$extension = strtolower(substr($imageName, $dotPosition)); 
$imageName_400 = $baseName . '_400' . $extension;

// Fallback to placeholder if file not found
if (!file_exists("images/" . $imageName_400)) {
    $imageName_400 = "placeholder_400.png";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($movie['title']) ?> - Movie Details</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>

  <?php include("header.php"); ?>

  <main>
    <div class="movie-detail-card">
      <h2><?= htmlspecialchars($movie['title']) ?></h2>

      <img src="images/<?= htmlspecialchars($imageName_400) ?>"
           alt="<?= htmlspecialchars($movie['title']) ?>" />

      <p><strong>Genre:</strong> <?= htmlspecialchars($movie['genreName']) ?></p>
      <p><strong>Director:</strong> <?= htmlspecialchars($movie['director']) ?></p>
      <p><strong>Year:</strong> <?= htmlspecialchars($movie['year']) ?></p>
      <p><strong>Language:</strong> <?= htmlspecialchars($movie['language']) ?></p>
      <p><strong>Duration:</strong> <?= htmlspecialchars($movie['duration']) ?></p>
      <p><strong>Rating:</strong> <?= htmlspecialchars($movie['rating']) ?></p>
      <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($movie['description'])) ?></p>
    </div>

    <a class="back-link" href="index.php">← Back to Movie List</a>
  </main>

  <?php include("footer.php"); ?>
</body>
</html>