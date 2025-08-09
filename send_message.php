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
        $sender_id = $_SESSION['user_id'];
        $receiver_email = $_POST['receiver_email'] ?? '';
        $message = $_POST['message'] ?? '';

        if (empty($receiver_email) || empty($message)) {
            echo "<script>alert('All fields are required.'); window.location.href = 'messages.php';</script>";
            exit;
        }

        $query = "SELECT id FROM users WHERE email = $1";
        $result = pg_query_params($conn, $query, [$receiver_email]);
        if (!$result) {
            error_log("Error fetching receiver: " . pg_last_error($conn));
            echo "<script>alert('Error finding receiver. Please try again.'); window.location.href = 'messages.php';</script>";
            exit;
        }

        if (pg_num_rows($result) > 0) {
            $receiver = pg_fetch_assoc($result);
            $receiver_id = $receiver['id'];

            $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($1, $2, $3)";
            $result = pg_query_params($conn, $query, [$sender_id, $receiver_id, $message]);

            if ($result) {
                echo "<script>alert('Message sent successfully.'); window.location.href = 'messages.php';</script>";
            } else {
                error_log("Error inserting message: " . pg_last_error($conn));
                echo "<script>alert('Error sending message. Please try again.'); window.location.href = 'messages.php';</script>";
            }
        } else {
            echo "<script>alert('Receiver not found.'); window.location.href = 'messages.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href = 'messages.php';</script>";
    }
} catch (Exception $e) {
    error_log("Exception in send_message.php: " . $e->getMessage());
    echo "<script>alert('An unexpected error occurred. Please try again.'); window.location.href = 'messages.php';</script>";
}

pg_close($conn);
?>
