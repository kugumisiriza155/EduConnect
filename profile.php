<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Update Profile Info
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating profile!";
    }
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile - <?php echo $user['username']; ?></title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <main class="profile-container">

        <section class="profile-header">
            <div class="avatar">
                <img src="<?php echo $user['avatar']; ?>" alt="Profile Picture">
                <form action="upload_avatar.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="avatar" id="avatar" hidden>
                    <label for="avatar" class="edit-avatar"><i class="fas fa-camera"></i></label>
                </form>
            </div>
            <h1><?php echo $user['username']; ?></h1>
            <p class="role"><?php echo ucfirst($user['role']); ?></p>
            <p class="email"><?php echo $user['email']; ?></p>
        </section>


        <div class="profile-content">

            <section class="enrolled-courses">
                <h2><i class="fas fa-book-open"></i> Enrolled Courses</h2>
                <div class="course-list">
                    <?php
                    $stmt = $conn->prepare("SELECT c.title, c.id FROM courses c 
                                          JOIN enrollments e ON c.id = e.course_id 
                                          WHERE e.user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $courses = $stmt->get_result();
                    
                    while ($course = $courses->fetch_assoc()):
                    ?>
                    <div class="course-item">
                        <h3><?php echo $course['title']; ?></h3>
                        <a href="course.php?id=<?php echo $course['id']; ?>" class="course-link">
                            Continue Learning
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>


            <section class="account-settings">
                <h2><i class="fas fa-cog"></i> Account Settings</h2>
                <?php include 'includes/alerts.php'; ?>
                <form method="POST" class="profile-form">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="name" value="<?php echo $user['username']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo $user['email']; ?>">
                    </div>

                    <button type="submit" name="update_profile" class="save-btn">Save Changes</button>
                </form>


                <div class="password-change">
                    <h3>Change Password</h3>
                    <form action="change_password.php" method="POST">
                        <div class="form-group">
                            <label>Current Password:</label>
                            <input type="password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label>New Password:</label>
                            <input type="password" name="new_password" required minlength="8">
                        </div>
                        <button type="submit" class="save-btn">Change Password</button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>

</html>