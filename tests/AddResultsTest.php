<?php
use PHPUnit\Framework\TestCase;

class AddResultsTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Create a mock database connection for testing
        $this->conn = new mysqli('localhost', 'root', '', 'test_database');

        // Ensure the test table exists and is clean
        $this->conn->query("CREATE TABLE IF NOT EXISTS results (
            id INT AUTO_INCREMENT PRIMARY KEY,
            reg_number VARCHAR(50) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            marks INT NOT NULL,
            grade CHAR(1) NOT NULL
        )");
        $this->conn->query("TRUNCATE TABLE results");
    }

    protected function tearDown(): void
    {
        // Clean up after each test
        $this->conn->query("DROP TABLE IF EXISTS results");
        $this->conn->close();
    }

    public function testAddResultsSuccess(): void
    {
        // Test data
        $reg_number = 'REG123';
        $subject = 'Mathematics';
        $marks = 95;
        $grade = 'A';

        // Prepare insert query
        $insert_query = "INSERT INTO results (reg_number, subject, marks, grade) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_query);
        $stmt->bind_param("ssss", $reg_number, $subject, $marks, $grade);
        $result = $stmt->execute();

        // Assert the result was successful
        $this->assertTrue($result);

        // Verify the data was inserted
        $query = "SELECT * FROM results WHERE reg_number = ? AND subject = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $reg_number, $subject);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->assertEquals(1, $result->num_rows);
        $row = $result->fetch_assoc();

        $this->assertEquals($marks, $row['marks']);
        $this->assertEquals($grade, $row['grade']);
    }

    public function testAddResultsWithInvalidMarks(): void
    {
        // Test data with invalid marks
        $reg_number = 'REG124';
        $subject = 'Science';
        $marks = -10; // Invalid marks
        $grade = 'F';

        // Prepare insert query
        $insert_query = "INSERT INTO results (reg_number, subject, marks, grade) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_query);
        $stmt->bind_param("ssss", $reg_number, $subject, $marks, $grade);

        // Attempt to execute and expect a failure
        $this->assertFalse($stmt->execute());
    }

    public function testAddResultsEdgeCase(): void
    {
        // Test data with edge case values
        $reg_number = 'REG125';
        $subject = 'History';
        $marks = 100; // Maximum valid marks
        $grade = 'A';

        // Prepare insert query
        $insert_query = "INSERT INTO results (reg_number, subject, marks, grade) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_query);
        $stmt->bind_param("ssss", $reg_number, $subject, $marks, $grade);
        $result = $stmt->execute();

        // Assert the result was successful
        $this->assertTrue($result);

        // Verify the data was inserted
        $query = "SELECT * FROM results WHERE reg_number = ? AND subject = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $reg_number, $subject);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->assertEquals(1, $result->num_rows);
        $row = $result->fetch_assoc();

        $this->assertEquals($marks, $row['marks']);
        $this->assertEquals($grade, $row['grade']);
    }
}
