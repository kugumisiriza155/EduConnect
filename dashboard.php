<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $file_name = basename($_FILES['file']['name']);
    $file_type = strpos($_FILES['file']['type'], 'image') !== false ? 'image' : 'video';

    if (move_uploaded_file($_FILES['file']['tmp_name'], "uploads/$file_name")) {
        $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_name, file_type) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $file_name, $file_type);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - EduConnect Uganda</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="dashboard">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

        <!-- Upload Form -->
        <form action="dashboard.php" method="POST" enctype="multipart/form-data">
            <label>Upload File:</label>
            <input type="file" name="file" accept="image/*, video/*" required>
            <button type="submit">Upload</button>
        </form>

        <!-- Uploaded Files -->
        <div class="uploads">
            <h3>Your Uploads</h3>
            <?php
            $stmt = $conn->prepare("SELECT * FROM uploads WHERE user_id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $uploads = $stmt->get_result();

            while ($row = $uploads->fetch_assoc()) {
                echo "<div class='file'>
                        <a href='uploads/{$row['file_name']}' target='_blank'>{$row['file_name']}</a>
                      </div>";
            }
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>