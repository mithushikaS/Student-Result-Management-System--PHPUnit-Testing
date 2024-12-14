<?php
use PHPUnit\Framework\TestCase;
use mysqli;

class EditStudentTest extends TestCase
{
    private $mockConn;
    private $mockStmt;
    private $studentId = 1;

    protected function setUp(): void
    {
        // Create a mock for the mysqli connection
        $this->mockConn = $this->createMock(mysqli::class);

        // Create a mock for the prepared statement
        $this->mockStmt = $this->createMock(mysqli_stmt::class);

        $this->mockConn
            ->method('prepare')
            ->willReturn($this->mockStmt);
    }

    public function testFetchStudentDetailsSuccess()
    {
        $expectedStudent = [
            'id' => $this->studentId,
            'name' => 'John Doe',
            'reg_number' => 'REG123',
            'class' => '10th Grade',
            'section' => 'A',
            'dob' => '2005-01-01'
        ];

        // Mock the statement's execute and get_result methods
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_assoc')->willReturn($expectedStudent);

        $this->mockStmt
            ->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $this->mockStmt
            ->method('get_result')
            ->willReturn($mockResult);

        // Execute the actual fetching logic
        $query = "SELECT * FROM students WHERE id = ?";
        $stmt = $this->mockConn->prepare($query);
        $stmt->bind_param("i", $this->studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();

        // Assertions
        $this->assertEquals($expectedStudent, $student);
    }

    public function testUpdateStudentDetailsSuccess()
    {
        $updatedData = [
            'name' => 'Jane Smith',
            'reg_number' => 'REG456',
            'class' => '11th Grade',
            'section' => 'B',
            'dob' => '2004-05-15'
        ];

        $this->mockStmt
            ->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $updateQuery = "UPDATE students SET name = ?, reg_number = ?, class = ?, section = ?, dob = ? WHERE id = ?";
        $stmt = $this->mockConn->prepare($updateQuery);
        $stmt->bind_param(
            "sssssi",
            $updatedData['name'],
            $updatedData['reg_number'],
            $updatedData['class'],
            $updatedData['section'],
            $updatedData['dob'],
            $this->studentId
        );

        $result = $stmt->execute();

        // Assertions
        $this->assertTrue($result);
    }

    public function testUpdateStudentDetailsFailure()
    {
        $updatedData = [
            'name' => 'Jane Smith',
            'reg_number' => 'REG456',
            'class' => '11th Grade',
            'section' => 'B',
            'dob' => '2004-05-15'
        ];

        $this->mockStmt
            ->expects($this->once())
            ->method('execute')
            ->willReturn(false);

        $updateQuery = "UPDATE students SET name = ?, reg_number = ?, class = ?, section = ?, dob = ? WHERE id = ?";
        $stmt = $this->mockConn->prepare($updateQuery);
        $stmt->bind_param(
            "sssssi",
            $updatedData['name'],
            $updatedData['reg_number'],
            $updatedData['class'],
            $updatedData['section'],
            $updatedData['dob'],
            $this->studentId
        );

        $result = $stmt->execute();

        // Assertions
        $this->assertFalse($result);
    }
}
