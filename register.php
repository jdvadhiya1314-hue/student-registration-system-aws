<?php
require_once 'db.php';

$errors = [];
$success_msg = "";

$full_name = "";
$enrollment_no = "";
$email = "";
$phone = "";
$course = "";
$semester = "";
$gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name     = trim($_POST['full_name'] ?? '');
    $enrollment_no = trim($_POST['enrollment_no'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $course        = trim($_POST['course'] ?? '');
    $semester      = trim($_POST['semester'] ?? '');
    $gender        = trim($_POST['gender'] ?? '');

    if (empty($full_name)) {
        $errors[] = "Full Name is required.";
    }

    if (empty($enrollment_no)) {
        $errors[] = "Enrollment Number is required.";
    }

    if (empty($email)) {
        $errors[] = "Email Address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match("/^[0-9+\-\s]{7,15}$/", $phone)) {
        $errors[] = "Please enter a valid phone number (7-15 digits).";
    }

    if (empty($course)) {
        $errors[] = "Please select a Course.";
    }

    if (empty($semester)) {
        $errors[] = "Please select a Semester.";
    }

    if (empty($gender)) {
        $errors[] = "Please select a Gender.";
    }

    if (empty($errors)) {
        $check_stmt = $conn->prepare("SELECT id FROM students WHERE enrollment_no = ?");
        $check_stmt->bind_param("s", $enrollment_no);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $errors[] = "A student with Enrollment Number '$enrollment_no' already exists.";
        }
        $check_stmt->close();
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO students (enrollment_no, full_name, email, phone, course, semester, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $enrollment_no, $full_name, $email, $phone, $course, $semester, $gender);

        if ($stmt->execute()) {
            $success_msg = "Student registered successfully!";
            $full_name = $enrollment_no = $email = $phone = $course = $semester = $gender = "";
        } else {
            $errors[] = "Database Error: Unable to register student. " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Register</title>
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
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php" class="active">Register Student</a></li>
                <li><a href="students.php">View Students</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        
        <div class="page-header">
            <div>
                <h1 class="page-title">Register New Student</h1>
                <p class="page-subtitle">Fill out the form below to add a new student record to the system.</p>
            </div>
            <a href="students.php" class="btn btn-secondary">📋 View Students List</a>
        </div>

        <div class="form-card">

            <?php if (!empty($success_msg)): ?>
                <div class="alert alert-success">
                    <span>✅ <?php echo htmlspecialchars($success_msg); ?></span>
                    <a href="students.php" style="margin-left: auto; color: var(--success); font-weight: 600;">View Students &rarr;</a>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" style="flex-direction: column; align-items: flex-start;">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin-top: 0.5rem; margin-left: 1.25rem;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" novalidate>
                <div class="form-grid">

                    <div class="form-group full-width">
                        <label class="form-label" for="full_name">Full Name <span>*</span></label>
                        <input type="text" id="full_name" name="full_name" class="form-control" placeholder="e.g. Aarav Sharma" value="<?php echo htmlspecialchars($full_name); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="enrollment_no">Enrollment Number / Student ID <span>*</span></label>
                        <input type="text" id="enrollment_no" name="enrollment_no" class="form-control" placeholder="e.g. EN2024001" value="<?php echo htmlspecialchars($enrollment_no); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address <span>*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="e.g. student@example.com" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number <span>*</span></label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="e.g. 9876543210" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="course">Course <span>*</span></label>
                        <select id="course" name="course" class="form-control" required>
                            <option value="">-- Select Course --</option>
                            <option value="Computer Science & Engineering" <?php echo ($course == 'Computer Science & Engineering') ? 'selected' : ''; ?>>Computer Science & Engineering</option>
                            <option value="Information Technology" <?php echo ($course == 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                            <option value="Bachelor of Computer Applications" <?php echo ($course == 'Bachelor of Computer Applications') ? 'selected' : ''; ?>>Bachelor of Computer Applications (BCA)</option>
                            <option value="Master of Computer Applications" <?php echo ($course == 'Master of Computer Applications') ? 'selected' : ''; ?>>Master of Computer Applications (MCA)</option>
                            <option value="Data Science & AI" <?php echo ($course == 'Data Science & AI') ? 'selected' : ''; ?>>Data Science & AI</option>
                            <option value="Electronics & Communication" <?php echo ($course == 'Electronics & Communication') ? 'selected' : ''; ?>>Electronics & Communication</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="semester">Semester <span>*</span></label>
                        <select id="semester" name="semester" class="form-control" required>
                            <option value="">-- Select Semester --</option>
                            <option value="Semester 1" <?php echo ($semester == 'Semester 1') ? 'selected' : ''; ?>>Semester 1</option>
                            <option value="Semester 2" <?php echo ($semester == 'Semester 2') ? 'selected' : ''; ?>>Semester 2</option>
                            <option value="Semester 3" <?php echo ($semester == 'Semester 3') ? 'selected' : ''; ?>>Semester 3</option>
                            <option value="Semester 4" <?php echo ($semester == 'Semester 4') ? 'selected' : ''; ?>>Semester 4</option>
                            <option value="Semester 5" <?php echo ($semester == 'Semester 5') ? 'selected' : ''; ?>>Semester 5</option>
                            <option value="Semester 6" <?php echo ($semester == 'Semester 6') ? 'selected' : ''; ?>>Semester 6</option>
                            <option value="Semester 7" <?php echo ($semester == 'Semester 7') ? 'selected' : ''; ?>>Semester 7</option>
                            <option value="Semester 8" <?php echo ($semester == 'Semester 8') ? 'selected' : ''; ?>>Semester 8</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Gender <span>*</span></label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="gender" value="Male" <?php echo ($gender == 'Male') ? 'checked' : ''; ?>> Male
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="Female" <?php echo ($gender == 'Female') ? 'checked' : ''; ?>> Female
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="Other" <?php echo ($gender == 'Other') ? 'checked' : ''; ?>> Other
                            </label>
                        </div>
                    </div>

                    <div class="form-group full-width" style="margin-top: 1rem; display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Register Student</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </div>

                </div>
            </form>

        </div>

    </main>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Student Registration System | Developed as a College Tiny Project</p>
    </footer>

</body>
</html>
