<?php
include 'includes/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $reg_number = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);

    $query = "INSERT INTO students (name, reg_number, class, section, dob) 
              VALUES ('$name', '$reg_number', '$class', '$section', '$dob')";

    if (mysqli_query($conn, $query)) {
        $success = "Student added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Student Results Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(120deg, #3498db, #2ecc71);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            width: 100%;
        }
        .card h2 {
            font-size: 1.8rem;
            color: #3498db;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2c80b4;
        }
        .form-text {
            color: #ff4d4d;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Add New Student</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="add_student.php">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter student's name" required>
            </div>
            <!-- Registration Number -->
            <div class="mb-3">
                <label for="reg_number" class="form-label">Registration Number</label>
                <input type="text" name="reg_number" id="reg_number" class="form-control" placeholder="Enter registration number" required>
            </div>
            <!-- Class -->
            <div class="mb-3">
                <label for="class" class="form-label">Class</label>
                <input type="text" name="class" id="class" class="form-control" placeholder="Enter class (e.g., 10th)" required>
            </div>
            <!-- Section -->
            <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" name="section" id="section" class="form-control" placeholder="Enter section (e.g., A)" required>
            </div>
            <!-- Date of Birth -->
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control" required>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Add Student</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
