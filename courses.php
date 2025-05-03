<!DOCTYPE html>
<html>

<head>
    <title>Courses - EduConnect Uganda</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="course-catalog">
        <h2>Available Courses</h2>
        <div class="course-list">
            <?php
            include 'includes/db.php';
            $result = $conn->query("SELECT * FROM courses");
            while ($course = $result->fetch_assoc()) {
                echo "<div class='course-card'>
                        <h3>{$course['title']}</h3>
                        <p>{$course['description']}</p>
                        <form action='enroll.php' method='POST'>
                            <input type='hidden' name='course_id' value='{$course['id']}'>
                            <button type='submit'>Enroll Now</button>
                        </form>
                      </div>";
            }
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>