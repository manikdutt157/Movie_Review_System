<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <h1>Movie Review System</h1>
        <ul>
            <a href="/">About</a>
            <a href="/">LogOut</a>
        </ul>
    </nav>
    <div class="container">
        <h1>Movies</h1>

        <a href="add_movie.php" class="add-movie-btn">Add New Movie</a>

        <div class="movie-list">

        <?php
        include 'db/db_connect.php';
        $sql = "SELECT * FROM movies";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="movie-item">';
                echo '<img src="movie_images/' . $row["image"] . '" alt="' . $row["title"] . '">';
                echo '<h3>' . $row["title"] . '</h3>';
                echo '<a href="review.php?id=' . $row["id"] . '" class="review-btn">Write Review</a>';
                echo '<a href="show_reviews.php?id=' . $row["id"] . '" class="show-reviews-btn">Show Reviews</a>';
                echo '</div>';
            }
        } else {
            echo "No movies found";
        }
        $conn->close();
        ?>
    </div>
</div>
<footer> &copy; Copyright by Manik Chandra Dutt</footer>
</body>
</html>