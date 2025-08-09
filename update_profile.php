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
        $job_title = $_POST['job_title'] ?? '';
        $summary = $_POST['summary'] ?? '';
        $education = $_POST['education'] ?? '';
        $experience = $_POST['experience'] ?? '';
        $skills = $_POST['skills'] ?? '';

        $query = "UPDATE users SET job_title = $1, summary = $2, education = $3, experience = $4, skills = $5 WHERE id = $6";
        $result = pg_query_params($conn, $query, [$job_title, $summary, $education, $experience, $skills, $user_id]);

        if ($result) {
            echo "<script>alert('Profile updated successfully.'); window.location.href = 'profile.php';</script>";
        } else {
            error_log("Error updating profile: " . pg_last_error($conn));
            echo "<script>alert('Error updating profile. Please try again.'); window.location.href = 'profile.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href = 'profile.php';</script>";
    }
} catch (Exception $e) {
    error_log("Exception in update_profile.php: " . $e->getMessage());
    echo "<script>alert('An unexpected error occurred. Please try again.'); window.location.href = 'profile.php';</script>";
}

pg_close($conn);
?>
