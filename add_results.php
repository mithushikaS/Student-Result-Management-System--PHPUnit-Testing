<?php
include 'includes/db.php';
include 'ResultsHandler.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_number = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $marks = mysqli_real_escape_string($conn, $_POST['marks']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);

    // Insert data into results table
    $insert_query = "INSERT INTO results (reg_number, subject, marks, grade) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssss", $reg_number, $subject, $marks, $grade);
    if ($stmt->execute()) {
        $success = "Results added successfully!";
        $stmt->close();
    } else {
        $error = "Failed to add results: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Results - Student Results Management</title>
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
        .form-control {
            border-radius: 5px;
            border-color: #ccc;
        }
        .alert {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Add Student Results</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="add_results.php">
            <!-- Registration Number -->
            <div class="mb-3">
                <label for="reg_number" class="form-label">Registration Number</label>
                <input type="text" name="reg_number" id="reg_number" class="form-control" required>
            </div>
            <!-- Subject -->
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" required>
            </div>
            <!-- Marks -->
            <div class="mb-3">
                <label for="marks" class="form-label">Marks</label>
                <input type="number" name="marks" id="marks" class="form-control" required>
            </div>
            <!-- Grade -->
            <div class="mb-3">
                <label for="grade" class="form-label">Grade</label>
                <select name="grade" id="grade" class="form-control" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Add Results</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
