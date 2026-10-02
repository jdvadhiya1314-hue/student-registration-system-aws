CREATE DATABASE IF NOT EXISTS `student_registration` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `student_registration`;

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `enrollment_no` VARCHAR(50) NOT NULL UNIQUE,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `course` VARCHAR(50) NOT NULL,
    `semester` VARCHAR(20) NOT NULL,
    `gender` ENUM('Male', 'Female', 'Other') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `students` (`enrollment_no`, `full_name`, `email`, `phone`, `course`, `semester`, `gender`) VALUES
('EN2024001', 'Aarav Sharma', 'aarav.sharma@example.com', '9876543210', 'Computer Science & Engineering', 'Semester 5', 'Male'),
('EN2024002', 'Priya Patel', 'priya.patel@example.com', '9876543211', 'Information Technology', 'Semester 3', 'Female'),
('EN2024003', 'Rohan Verma', 'rohan.verma@example.com', '9876543212', 'Bachelor of Computer Applications', 'Semester 1', 'Male'),
('EN2024004', 'Ananya Gupta', 'ananya.gupta@example.com', '9876543213', 'Master of Computer Applications', 'Semester 2', 'Female'),
('EN2024005', 'Vikram Singh', 'vikram.singh@example.com', '9876543214', 'Data Science & AI', 'Semester 4', 'Male');
