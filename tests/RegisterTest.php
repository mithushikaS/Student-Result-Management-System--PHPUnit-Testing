<?php
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    private $conn;

    // Setup a mock database connection (use your actual database for integration testing)
    protected function setUp(): void
    {
        $this->conn = $this->getMockBuilder('mysqli')
            ->disableOriginalConstructor()
            ->getMock();
    }

    // Mock the function that simulates the form submission
    private function submitRegistrationForm($data)
    {
        // Simulate your registration logic here, for example:
        if ($data['password'] !== $data['confirm_password']) {
            return 'Passwords do not match!';
        }

        // Simulate successful registration
        if ($data['password'] === $data['confirm_password']) {
            // You would typically insert data into the database here and check for errors
            // For testing, we can assume success
            return 'Registration successful! You can now login.';
        }

        // Simulate a database error
        return 'Database error';
    }

    public function testPasswordMismatch()
    {
        $response = $this->submitRegistrationForm([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'confirm_password' => 'password321',
        ]);

        $this->assertStringContainsString('Passwords do not match!', $response);
    }

    public function testSuccessfulRegistration()
    {
        $response = $this->submitRegistrationForm([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
        ]);

        $this->assertStringContainsString('Registration successful! You can now login.', $response);
    }

    public function testDatabaseError()
    {
        // Simulate a database error by throwing an exception in the query method
        $this->conn->method('query')
            ->will($this->throwException(new Exception('Database error')));
    
        // Simulate the response from the registration form
        $response = $this->submitRegistrationForm([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
        ]);
    
        // Check if the response contains the database error message
        $this->assertStringContainsString('Database error', $response);
    }
    
}
?>

