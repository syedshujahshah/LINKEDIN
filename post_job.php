<?php
session_start();
require_once 'db.php';

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

try {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'];
        $title = $_POST['title'] ?? '';
        $location = $_POST['location'] ?? '';
        $industry = $_POST['industry'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($title) || empty($location) || empty($industry) || empty($description)) {
            echo "<script>alert('All fields are required.'); window.location.href = 'jobs.php';</script>";
            exit;
        }

        $query = "INSERT INTO jobs (user_id, title, location, industry, description) VALUES ($1, $2, $3, $4, $5)";
        $result = pg_query_params($conn, $query, [$user_id, $title, $location, $industry, $description]);

        if ($result) {
            echo "<script>alert('Job posted successfully.'); window.location.href = 'jobs.php';</script>";
        } else {
            error_log("Error inserting job: " . pg_last_error($conn));
            echo "<script>alert('Error posting job. Please try again.'); window.location.href = 'jobs.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href = 'jobs.php';</script>";
    }
} catch (Exception $e) {
    error_log("Exception in post_job.php: " . $e->getMessage());
    echo "<script>alert('An unexpected error occurred. Please try again.'); window.location.href = 'jobs.php';</script>";
}

pg_close($conn);
?>
