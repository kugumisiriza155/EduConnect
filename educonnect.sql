CREATE DATABASE educonnect;
USE educonnect;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- For hashed passwords
    role ENUM('student', 'teacher', 'admin') DEFAULT 'student',
    verified BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE uploads (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_type ENUM('image', 'video') NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    instructor_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(id)
);

CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, course_id)
);

-- Indexes for Optimization
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_courses_title ON courses(title);


sql
-- Insert Sample User (Instructor)
INSERT INTO users (username, email, password, role, verified)
VALUES ('arthur kum', 'arthur@educonnect.ug', '$2y$10$EXAMPLEHASHEDPASSWORD', 'instructor', 1);

-- Insert Sample Course
INSERT INTO courses (title, description, category, instructor_id)
VALUES ('Web Development Basics', 'Learn HTML, CSS, and JavaScript', 'Technology', 1);

-- Enroll Sample Student
INSERT INTO enrollments (user_id, course_id)
VALUES (2, 1); -- Assuming user_id 2 exists

-- Upload Sample File
INSERT INTO uploads (user_id, course_id, file_name, file_type)
VALUES (1, 1, 'intro-video.mp4', 'video');
