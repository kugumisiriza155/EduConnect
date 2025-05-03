<!DOCTYPE html>
<html>

<head>
    <title>Contact Us - EduConnect Uganda</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="form-container">
        <h2>Contact Us</h2>
        <form action="process_contact.php" method="POST">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Message:</label>
            <textarea name="message" rows="5" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>