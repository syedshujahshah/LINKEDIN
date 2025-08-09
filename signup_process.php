<?php
session_start();
require_once 'db.php';

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

        if (empty($name) || empty($email) || empty($_POST['password'])) {
            echo "<script>alert('All fields are required.'); window.location.href = 'signup.php';</script>";
            exit;
        }

        // Check if email already exists
        $query = "SELECT id FROM users WHERE email = $1";
        $result = pg_query_params($conn, $query, [$email]);
        if (!$result) {
            error_log("Error checking email: " . pg_last_error($conn));
            echo "<script>alert('Error checking email. Please try again.'); window.location.href = 'signup.php';</script>";
            exit;
        }

        if (pg_num_rows($result) > 0) {
            echo "<script>alert('Email already registered.'); window.location.href = 'signup.php';</script>";
            exit;
        }

        // Insert new user
        $query = "INSERT INTO users (name, email, password) VALUES ($1, $2, $3) RETURNING id";
        $result = pg_query_params($conn, $query, [$name, $email, $password]);
        if ($result) {
            $row = pg_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            echo "<script>alert('Account created successfully.'); window.location.href = 'profile.php';</script>";
        } else {
            error_log("Error inserting user: " . pg_last_error($conn));
            echo "<script>alert('Error creating account. Please try again.'); window.location.href = 'signup.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href = 'signup.php';</script>";
    }
} catch (Exception $e) {
    error_log("Exception in signup_process.php: " . $e->getMessage());
    echo "<script>alert('An unexpected error occurred. Please try again.'); window.location.href = 'signup.php';</script>";
}

pg_close($conn);
?>
