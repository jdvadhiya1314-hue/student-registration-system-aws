<?php
require_once 'db.php';

$errors = [];
$student_id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$student_id || !is_numeric($student_id)) {
    header("Location: students.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: students.php");
    exit();
}

$student = $result->fetch_assoc();
$stmt->close();

$full_name     = $student['full_name'];
$enrollment_no = $student['enrollment_no'];
$email         = $student['email'];
$phone         = $student['phone'];
$course        = $student['course'];
$semester      = $student['semester'];
$gender        = $student['gender'];

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
        $check_stmt = $conn->prepare("SELECT id FROM students WHERE enrollment_no = ? AND id != ?");
        $check_stmt->bind_param("si", $enrollment_no, $student_id);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $errors[] = "Enrollment Number '$enrollment_no' is already assigned to another student.";
        }
        $check_stmt->close();
    }

    if (empty($errors)) {
        $update_stmt = $conn->prepare("UPDATE students SET enrollment_no = ?, full_name = ?, email = ?, phone = ?, course = ?, semester = ?, gender = ? WHERE id = ?");
        $update_stmt->bind_param("sssssssi", $enrollment_no, $full_name, $email, $phone, $course, $semester, $gender, $student_id);

        if ($update_stmt->execute()) {
            $update_stmt->close();
            header("Location: students.php?msg=updated");
            exit();
        } else {
            $errors[] = "Database Error: Could not update record. " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - #<?php echo htmlspecialchars($student_id); ?></title>
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
                <li><a href="register.php">Register Student</a></li>
                <li><a href="students.php">View Students</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">

        <div class="page-header">
            <div>
                <h1 class="page-title">Edit Student Information</h1>
                <p class="page-subtitle">Updating record for Student ID #<?php echo htmlspecialchars($student_id); ?></p>
            </div>
            <a href="students.php" class="btn btn-secondary">⬅ Back to Students List</a>
        </div>

        <div class="form-card">

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

            <form action="edit.php?id=<?php echo $student_id; ?>" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($student_id); ?>">

                <div class="form-grid">

                    <div class="form-group full-width">
                        <label class="form-label" for="full_name">Full Name <span>*</span></label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($full_name); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="enrollment_no">Enrollment Number / Student ID <span>*</span></label>
                        <input type="text" id="enrollment_no" name="enrollment_no" class="form-control" value="<?php echo htmlspecialchars($enrollment_no); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address <span>*</span></label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number <span>*</span></label>
                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" required>
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
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Save Changes</button>
                        <a href="students.php" class="btn btn-secondary">Cancel</a>
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
