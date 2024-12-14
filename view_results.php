<?php
include 'includes/db.php';

// Handle search form submission
$search_error = "";
$results_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);

    // Check if the search term is empty
    if (empty($search_term)) {
        $search_error = "Please enter a Registration Number or Name to search.";
    } else {
        // Query to fetch student results based on search term (Reg Number or Name)
        $query = "SELECT r.reg_number, r.subject, r.marks, r.grade, s.name 
                  FROM results r 
                  JOIN students s ON r.reg_number = s.reg_number 
                  WHERE r.reg_number LIKE ? OR s.name LIKE ?";
        $stmt = $conn->prepare($query);
        $search_term_wildcard = "%" . $search_term . "%";
        $stmt->bind_param("ss", $search_term_wildcard, $search_term_wildcard);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $results_data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $search_error = "No results found for '$search_term'.";
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
    <title>View Student Results - Student Results Management</title>
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
            max-width: 600px;
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
        .alert {
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        table th {
            background-color: #2193b0;
            color: black;
        }
        table td, table th {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>View Student Results</h2>

        <!-- Search Form -->
        <form method="POST" action="view_results.php">
            <div class="mb-3">
                <label for="search_term" class="form-label">Search by Registration Number or Name</label>
                <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Enter Registration Number or Name" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </form>

        <!-- Display error or success message -->
        <?php if (!empty($search_error)): ?>
            <div class="alert alert-danger mt-3"><?php echo $search_error; ?></div>
        <?php endif; ?>

        <!-- Display Results -->
        <?php if (!empty($results_data)): ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Registration Number</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results_data as $result): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['reg_number']); ?></td>
                            <td><?php echo htmlspecialchars($result['name']); ?></td>
                            <td><?php echo htmlspecialchars($result['subject']); ?></td>
                            <td><?php echo htmlspecialchars($result['marks']); ?></td>
                            <td><?php echo htmlspecialchars($result['grade']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
