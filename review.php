<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Review Movie</title>
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
    <h1>Review Movie</h1>
  <div class="container-review">
    <div class="image-review">

      <?php
    include 'db/db_connect.php';
    if (isset($_GET['id'])) {
      $movieId = $_GET['id'];
      

      $stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
      $stmt->bind_param("i", $movieId);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
        
        $imagePath = "movie_images/" . $movie["image"];
        
        
        if (file_exists($imagePath)) {
          
          echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($movie["title"]) . '" style="max-width: 300px; height: auto;">';
        } else {
          echo '<p>Image not found: ' . htmlspecialchars($imagePath) . '</p>';
        }
        
        echo '<h2>' . htmlspecialchars($movie["title"]) . '</h2>';
      } else {
        echo "Movie not found";
      }
    } else {
      echo "No movie selected";
    }
    ?>
    </div>

    <div class="form-review">

      
      <form class="review-form" action="submit_review.php" method="post">
        <input type="hidden" name="movie_id" value="<?php echo isset($movieId) ? htmlspecialchars($movieId) : ''; ?>">
        <label for="review">Review:</label>
        <textarea id="review" name="review" rows="4" required></textarea>
        
        <label for="rating">Rating:</label>
        <div class="rating">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <span class="fa fa-star checked" data-value="1⭐"></span>
          <span class="fa fa-star checked" data-value="2⭐"></span>
          <span class="fa fa-star checked" data-value="3⭐"></span>
          <span class="fa fa-star" data-value="4⭐"></span>
          <span class="fa fa-star" data-value="5⭐"></span>
          <input type="hidden" name="rating" id="rating" value="3⭐"> <!-- Default rating value -->
        </div>
        
        <button type="submit">Submit Review</button>
        <a href="show_reviews.php?id=<?php echo isset($movieId) ? htmlspecialchars($movieId) : ''; ?>" class="show-reviews-btn">Show Reviews</a>
      </form>
    </div>
      
      <style>
      .checked {
        color: orange;
      }
      .rating span {
        cursor: pointer;
      }
    </style>

    <script>
      document.querySelectorAll('.rating span').forEach((star) => {
          star.addEventListener('click', () => {
              const rating = star.getAttribute('data-value');
              document.getElementById('rating').value = rating; // Set the hidden input value
              updateStars(rating); // Update the visual stars
          });
      });

      function updateStars(rating) {
          document.querySelectorAll('.rating span').forEach((star, index) => {
              if (index < rating) {
                  star.classList.add('checked');
              } else {
                  star.classList.remove('checked');
              }
          });
      }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $review = $_POST['review'];
      $rating = $_POST['rating'];
      
      include 'db/db_connect.php';
      
      $sql = "INSERT INTO reviews (movie_id, review, rating) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("isi", $movieId, $review, $rating);
      $stmt->execute();
      
      echo '<script>alert("Review submitted successfully!");</script>';
    }
    ?>
  </div>
</body>
</html>