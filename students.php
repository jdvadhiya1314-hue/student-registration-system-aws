<?php
require_once 'db.php';

$search = trim($_GET['search'] ?? '');

if (!empty($search)) {
    $search_param = "%" . $search . "%";
    $stmt = $conn->prepare("SELECT * FROM students WHERE full_name LIKE ? OR enrollment_no LIKE ? ORDER BY id DESC");
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
}

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students List</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete(studentName, studentId) {
            return confirm("Are you sure you want to delete the student record for '" + studentName + "' (ID: " + studentId + ")?\n\nThis action cannot be undone!");
        }
    </script>
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
                <li><a href="students.php" class="active">View Students</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">

        <div class="page-header">
            <div>
                <h1 class="page-title">Registered Students</h1>
                <p class="page-subtitle">Manage, view, search, edit, or delete enrolled student records.</p>
            </div>
            <a href="register.php" class="btn btn-primary">➕ Register New Student</a>
        </div>

        <?php if ($msg === 'updated'): ?>
            <div class="alert alert-success">
                ✅ Student record has been updated successfully!
            </div>
        <?php elseif ($msg === 'deleted'): ?>
            <div class="alert alert-danger">
                🗑️ Student record has been deleted successfully.
            </div>
        <?php endif; ?>

        <div class="table-controls">
            <form action="students.php" method="GET" class="search-form">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control search-input" 
                    placeholder="Search by Name or Enrollment No..." 
                    value="<?php echo htmlspecialchars($search); ?>"
                >
                <button type="submit" class="btn btn-secondary">🔍 Search</button>
                <?php if (!empty($search)): ?>
                    <a href="students.php" class="btn btn-secondary" title="Clear Search">✖ Reset</a>
                <?php endif; ?>
            </form>
            <div style="font-size: 0.9rem; color: var(--text-muted);">
                Showing <strong><?php echo $result ? $result->num_rows : 0; ?></strong> student record(s)
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Enrollment No.</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>Gender</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--secondary);">
                                            <?php echo htmlspecialchars($row['full_name']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <code style="background:#f1f5f9; padding: 2px 6px; border-radius:4px; font-size:0.85rem;">
                                            <?php echo htmlspecialchars($row['enrollment_no']); ?>
                                        </code>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td>
                                        <span class="badge badge-course">
                                            <?php echo htmlspecialchars($row['course']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['semester']); ?></td>
                                    <td>
                                        <?php 
                                            $g = strtolower($row['gender']);
                                            $badge_class = "badge-gender-other";
                                            if ($g === 'male') $badge_class = "badge-gender-male";
                                            if ($g === 'female') $badge_class = "badge-gender-female";
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo htmlspecialchars($row['gender']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons" style="justify-content: center;">
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" title="Edit Student">
                                                ✏️ Edit
                                            </a>
                                            <a 
                                                href="delete.php?id=<?php echo $row['id']; ?>" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="return confirmDelete('<?php echo addslashes(htmlspecialchars($row['full_name'])); ?>', '<?php echo $row['id']; ?>');"
                                                title="Delete Student"
                                            >
                                                🗑️ Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📂</div>
                                        <h3>No Students Found</h3>
                                        <p style="margin-top: 0.25rem;">
                                            <?php if (!empty($search)): ?>
                                                No student record matches your search criteria "<strong><?php echo htmlspecialchars($search); ?></strong>".
                                            <?php else: ?>
                                                No student records exist in the database yet.
                                            <?php endif; ?>
                                        </p>
                                        <a href="register.php" class="btn btn-primary" style="margin-top: 1rem;">
                                            ➕ Register First Student
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Student Registration System | Developed as a College Tiny Project</p>
    </footer>

</body>
</html>
