<?php
// user_authentication.php
class UserAuthentication {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($username, $password) {
        $username = $this->conn->real_escape_string($username);

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row["password"])) {
                session_start();
                $_SESSION["login"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                header("Location: dashboard.php");
            } else {
                $loginError = "Kombinasi username dan password salah";
            }
        } else {
            $error = "Pengguna tidak ditemukan";
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

?>