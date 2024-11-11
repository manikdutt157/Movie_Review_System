<!DOCTYPE html>
<html>
<head>
    <title>Add Movie</title>
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

        <h1>Add New Movie</h1>
        <div class="movie-form">

            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="title">Movie Title:</label>
                <input type="text" name="title" required><br><br>
                
                <label for="image">Movie Image:</label>
                <input type="file" name="image" accept="image/*" required><br><br>
                
                <input type="submit" value="Add Movie">
            </form>
            
        </div>
    </div>
</body>
</html>

<?php
include 'db/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    
    // Handle file upload
    $target_dir = "movie_images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check === false) {
            die("File is not an image.");
        }
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }
    
    // Upload file
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert into database
        $sql = "INSERT INTO movies (title, image) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $image_path = basename($_FILES["image"]["name"]);
        $stmt->bind_param("ss", $title, $image_path);
        
        if ($stmt->execute()) {
            echo "Movie added successfully";
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$conn->close();
?>