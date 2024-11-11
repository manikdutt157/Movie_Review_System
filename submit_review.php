<?php
include 'db/db_connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $movieId = $_POST['movie_id'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];

    // Validate input
    if (empty($movieId) || empty($review) || empty($rating)) {
        echo "Please fill in all fields.";
        exit; // Stop further execution
    }

    // Prepare SQL statement to insert review
    $sql = "INSERT INTO reviews (movie_id, review, rating) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("isi", $movieId, $review, $rating);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<p>Review submitted successfully!</p>";
        // Redirect to the show reviews page
        header("Location: show_reviews.php?id=" . $movieId);
        exit();
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>