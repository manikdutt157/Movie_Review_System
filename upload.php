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
?>