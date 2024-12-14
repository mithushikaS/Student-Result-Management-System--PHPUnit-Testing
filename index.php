<?php
// Include the database connection
include 'includes/db.php';

// Fetch the number of students
$studentCountQuery = "SELECT COUNT(*) AS total_students FROM students";
$studentCountResult = mysqli_query($conn, $studentCountQuery);
$studentCount = mysqli_fetch_assoc($studentCountResult)['total_students'];

// Fetch the number of results
$resultCountQuery = "SELECT COUNT(*) AS total_results FROM results";
$resultCountResult = mysqli_query($conn, $resultCountQuery);
$resultCount = mysqli_fetch_assoc($resultCountResult)['total_results'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results Management - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Student Results Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="manage_students.php">Manage Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_results.php">Add Results</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_results.php">View Results</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container my-5">
        <div class="row text-center">
            <h1 class="mb-4">Welcome to the Dashboard</h1>
            <p class="text-muted">Manage students and results with ease.</p>
        </div>
        <div class="row g-4">
            <!-- Card: Total Students -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Total Students</h5>
                        <h2 class="display-4 text-primary"><?php echo $studentCount; ?></h2>
                        <a href="manage_students.php" class="btn btn-primary mt-3">Manage Students</a>
                    </div>
                </div>
            </div>
            <!-- Card: Total Results -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Total Results</h5>
                        <h2 class="display-4 text-success"><?php echo $resultCount; ?></h2>
                        <a href="view_results.php" class="btn btn-success mt-3">View Results</a>
                    </div>
                </div>
            </div>
            <!-- Card: Add Results -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Add Results</h5>
                        <p class="text-muted">Add new results for students.</p>
                        <a href="add_results.php" class="btn btn-warning mt-3">Add Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <small>&copy; 2024 Student Results Management System. All Rights Reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
