<?php
require_once 'db.php';

$total_students = 0;
$result = $conn->query("SELECT COUNT(*) AS total FROM students");
if ($result) {
    $row = $result->fetch_assoc();
    $total_students = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration System - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-brand">
                <svg viewBox="0 0 24 24">
                    <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                </svg>
                StudentReg System
            </a>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="register.php">Register Student</a></li>
                <li><a href="students.php">View Students</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">

        <section class="hero-card">
            <span class="hero-badge">College Tiny Project</span>
            <h1 class="hero-title">Student Registration System</h1>
            <p class="hero-description">
                A simple, clean, and robust web application to manage student admissions, records, course enrollments, and profiles with ease and reliability.
            </p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">
                    ➕ Register New Student
                </a>
                <a href="students.php" class="btn btn-secondary">
                    📋 View All Students (<?php echo $total_students; ?>)
                </a>
            </div>
        </section>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🎓</div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo $total_students; ?></div>
                    <div class="stat-label">Total Registered Students</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-info">
                    <div class="stat-value">5+</div>
                    <div class="stat-label">Available Programs & Courses</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⚡</div>
                <div class="stat-info">
                    <div class="stat-value">Instant</div>
                    <div class="stat-label">Search & Data Processing</div>
                </div>
            </div>
        </div>

        <h2 style="font-size: 1.4rem; color: var(--secondary); margin-bottom: 1rem;">System Features</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📝</div>
                <h3>Student Registration</h3>
                <p>Register new students with full details including ID, Enrollment Number, Course, Semester, Email, and Phone number with complete validation.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Quick Search</h3>
                <p>Easily search registered students by Full Name or unique Enrollment Number in real-time.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✏️</div>
                <h3>Edit & Update</h3>
                <p>Modify student records effortlessly whenever course, semester, or contact details require updates.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🗑️</div>
                <h3>Delete Management</h3>
                <p>Remove obsolete student entries safely with interactive JavaScript confirmation modals.</p>
            </div>
        </div>

    </main>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Student Registration System | Developed as a College Tiny Project</p>
    </footer>

</body>
</html>
