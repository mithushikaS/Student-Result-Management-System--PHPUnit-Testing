<?php
include 'includes/db.php';

// Fetch student data for editing
$student_id = $_GET['id'] ?? null;
if ($student_id) {
    $query = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    if (!$student) {
        die("Student not found!");
    }
} else {
    die("Invalid student ID!");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $reg_number = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);

    $update_query = "UPDATE students SET name = ?, reg_number = ?, class = ?, section = ?, dob = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $name, $reg_number, $class, $section, $dob, $student_id);
    if ($stmt->execute()) {
        $success = "Student details updated successfully!";
        $stmt->close();
        // Redirect to manage_student.php after the update
        header("Location: manage_students.php");
        exit(); // Prevent further script execution
    } else {
        $error = "Failed to update student: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Results Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #6dd5ed, #2193b0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }
        .card h2 {
            color: #2193b0;
            text-align: center;
        }
        .btn-primary {
            background-color: #2193b0;
            border: none;
        }
        .btn-primary:hover {
            background-color: #176d82;
        }
        .form-text {
            color: #ff4d4d;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Student Details</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="edit_student.php?id=<?php echo $student_id; ?>">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>
            <!-- Registration Number -->
            <div class="mb-3">
                <label for="reg_number" class="form-label">Registration Number</label>
                <input type="text" name="reg_number" id="reg_number" class="form-control" value="<?php echo htmlspecialchars($student['reg_number']); ?>" required>
            </div>
            <!-- Class -->
            <div class="mb-3">
                <label for="class" class="form-label">Class</label>
                <input type="text" name="class" id="class" class="form-control" value="<?php echo htmlspecialchars($student['class']); ?>" required>
            </div>
            <!-- Section -->
            <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" name="section" id="section" class="form-control" value="<?php echo htmlspecialchars($student['section']); ?>" required>
            </div>
            <!-- Date of Birth -->
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control" value="<?php echo htmlspecialchars($student['dob']); ?>" required>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Update Student</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


