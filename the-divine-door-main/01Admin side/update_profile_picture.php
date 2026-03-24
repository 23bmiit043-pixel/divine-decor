<?php
session_start();
include('connect.php');

if(!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true) {
    header("Location: admin_login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    $upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
    $admin_id = $_SESSION['admin_id'];
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $upload_dir . $new_filename;
    
    // Check file type
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if(!in_array($file_extension, $allowed_types)) {
        $_SESSION['error'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: profile.php");
        exit;
    }
    
    if(move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        // Update database with new profile picture
        $query = "UPDATE admin SET adminProfile = ? WHERE aid = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $new_filename, $admin_id);
        
        if(mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Profile picture updated successfully.";
        } else {
            $_SESSION['error'] = "Error updating profile picture in database.";
        }
    } else {
        $_SESSION['error'] = "Error uploading file.";
    }
}

header("Location: profile.php");
exit;
