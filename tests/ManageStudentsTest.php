<?php
use PHPUnit\Framework\TestCase;

class ManageStudentsTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Create a mock database connection for testing
        $this->conn = new mysqli('localhost', 'root', '', 'test_database');

        // Ensure the test table exists and is clean
        $this->conn->query("CREATE TABLE IF NOT EXISTS students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            reg_number VARCHAR(50),
            class VARCHAR(50),
            section VARCHAR(50),
            dob DATE
        )");
        $this->conn->query("TRUNCATE TABLE students");
    }

    protected function tearDown(): void
    {
        // Clean up after each test
        $this->conn->query("DROP TABLE IF EXISTS students");
        $this->conn->close();
    }

    public function testFetchStudents(): void
    {
        // Insert test data
        $this->conn->query("INSERT INTO students (name, reg_number, class, section, dob) VALUES
            ('John Doe', 'REG123', '10th Grade', 'A', '2005-01-15'),
            ('Jane Smith', 'REG124', '9th Grade', 'B', '2006-02-20')");

        // Fetch data
        $query = "SELECT * FROM students ORDER BY id DESC";
        $result = $this->conn->query($query);

        $this->assertEquals(2, $result->num_rows);
        $row = $result->fetch_assoc();
        $this->assertEquals('Jane Smith', $row['name']);
    }

    public function testDeleteStudent(): void
    {
        // Insert test data
        $this->conn->query("INSERT INTO students (name, reg_number, class, section, dob) VALUES
            ('John Doe', 'REG123', '10th Grade', 'A', '2005-01-15')");

        $deleteId = $this->conn->insert_id;

        // Prepare delete query
        $deleteQuery = "DELETE FROM students WHERE id = ?";
        $stmt = $this->conn->prepare($deleteQuery);
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();

        $this->assertEquals(1, $stmt->affected_rows);

        // Verify deletion
        $result = $this->conn->query("SELECT * FROM students WHERE id = $deleteId");
        $this->assertEquals(0, $result->num_rows);
    }

    public function testEdgeCaseDeletion(): void
    {
        // Try to delete a non-existent student
        $deleteId = 999; // Non-existent ID
        $deleteQuery = "DELETE FROM students WHERE id = ?";
        $stmt = $this->conn->prepare($deleteQuery);
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();

        // Assert no rows are affected
        $this->assertEquals(0, $stmt->affected_rows);
    }
}
