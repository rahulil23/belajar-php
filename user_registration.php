<?php
// user_registration.php
class UserRegistration
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($name, $email, $phone_number, $password)
    {
        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $phone_number = $this->conn->real_escape_string($phone_number);

        // Generate username from phone number
        $username = $phone_number;

        // Default group_id value
        $group_id = 3;

        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user data into the database
        $sql = "INSERT INTO users (name, email, phone_number, username, password, group_id) VALUES ('$name', '$email', '$phone_number', '$username', '$hashed_password', $group_id)";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}
?>