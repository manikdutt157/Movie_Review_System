<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show Reviews</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav>
        <h1>Movie Review System</h1>
        <ul>
            <a href="">About</a>
            <a href="">LogOut</a>
        </ul>
    </nav>
  <div class="container">

    <h1>Reviews</h1>
    <div class="review-show">

      <?php
    include 'db/db_connect.php'; // Include your database connection file
    
    // Check if the movie ID is set in the URL
    if (isset($_GET['id'])) {
      $movieId = $_GET['id'];
      
      // Prepare SQL statement to fetch reviews for the movie
      $sql = "SELECT * FROM reviews WHERE movie_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $movieId);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if ($result->num_rows > 0) {
        echo "<h2>All Reviews:</h2>";
        while($row = $result->fetch_assoc()) {
          echo '<div class="review-item">';
          echo '<p>Review : ' . htmlspecialchars($row["review"]) . '</p>';
          echo '<p>Rating : ' . htmlspecialchars($row["rating"]) . '</p>';
          echo '</div>';
        }
      } else {
        echo "No reviews found for this movie.";
      }
      
      // Close the statement
      $stmt->close();
    } else {
      echo "No movie selected.";
    }
    
    // Close the database connection
    $conn->close();
    ?>
</div>

<a href="index.php">Back to Movie List</a>
</div>
</body>
</html>