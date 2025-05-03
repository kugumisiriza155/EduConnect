<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $user_id = $_SESSION['user_id'];
    $target_dir = "uploads/avatars/";
    $file_name = uniqid() . '-' . basename($_FILES['avatar']['name']);
    $target_file = $target_dir . $file_name;
    $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image
    $check = getimagesize($_FILES['avatar']['tmp_name']);
    if ($check === false) {
        $_SESSION['error'] = "File is not an image!";
        header("Location: profile.php");
        exit();
    }

    // Limit file size to 2MB
    if ($_FILES['avatar']['size'] > 2000000) {
        $_SESSION['error'] = "File too large (max 2MB)!";
        header("Location: profile.php");
        exit();
    }

    // Allow only specific formats
    if (!in_array($image_type, ['jpg', 'png', 'jpeg', 'gif'])) {
        $_SESSION['error'] = "Only JPG, JPEG, PNG & GIF allowed!";
        header("Location: profile.php");
        exit();
    }

    // Upload and update database
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->bind_param("si", $target_file, $user_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Avatar updated!";
        } else {
            $_SESSION['error'] = "Error updating avatar!";
        }
    } else {
        $_SESSION['error'] = "Error uploading file!";
    }
    header("Location: profile.php");
    exit();
}
