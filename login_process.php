<?php
session_start();
require_once 'db.php';

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo "<script>alert('All fields are required.'); window.location.href = 'login.php';</script>";
            exit;
        }

        $query = "SELECT id, password FROM users WHERE email = $1";
        $result = pg_query_params($conn, $query, [$email]);
        if (!$result) {
            error_log("Error fetching user: " . pg_last_error($conn));
            echo "<script>alert('Error logging in. Please try again.'); window.location.href = 'login.php';</script>";
            exit;
        }

        if (pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                echo "<script>alert('Login successful.'); window.location.href = 'profile.php';</script>";
            } else {
                echo "<script>alert('Invalid password.'); window.location.href = 'login.php';</script>";
            }
        } else {
            echo "<script>alert('User not found.'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href = 'login.php';</script>";
    }
} catch (Exception $e) {
    error_log("Exception in login_process.php: " . $e->getMessage());
    echo "<script>alert('An unexpected error occurred. Please try again.'); window.location.href = 'login.php';</script>";
}

pg_close($conn);
?>
