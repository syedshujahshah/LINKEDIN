<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f4f8;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .navbar {
            background-color: #0073b1;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .message-form, .message-list {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .message-form input, .message-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .message-form button {
            padding: 10px 20px;
            background: #0073b1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .message-form button:hover {
            background: #005f8d;
        }
        .message-list .message {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?php
    session_start();
    require_once 'db.php';
    if (!isset($_SESSION['user_id'])) {
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $query = "SELECT m.*, u.name FROM messages m JOIN users u ON m.sender_id = u.id WHERE m.receiver_id = $1";
    $result = pg_query_params($conn, $query, [$user_id]);
    if (!$result) {
        error_log("Error fetching messages: " . pg_last_error($conn));
        echo "<script>alert('Error loading messages. Please try again.'); window.location.href = 'index.php';</script>";
        exit;
    }
    $messages = pg_fetch_all($result);
    ?>
    <div class="navbar">
        <a href="index.php" onclick="return navigate('index.php')">Home</a>
        <a href="profile.php" onclick="return navigate('profile.php')">Profile</a>
        <a href="jobs.php" onclick="return navigate('jobs.php')">Jobs</a>
        <a href="messages.php" onclick="return navigate('messages.php')">Messages</a>
    </div>
    <div class="container">
        <div class="message-form">
            <h2>Send Message</h2>
            <form id="messageForm" action="send_message.php" method="POST">
                <input type="text" name="receiver_email" placeholder="Receiver Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
        <div class="message-list">
            <h2>Inbox</h2>
            <?php if ($messages): ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message">
                        <p><strong><?php echo htmlspecialchars($message['name']); ?>:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No messages.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function navigate(page) {
            try {
                console.log('Navigating to:', page);
                window.location.href = page;
                return false;
            } catch (e) {
                console.error('Navigation error:', e);
                alert('Navigation failed. Please ensure JavaScript is enabled.');
                return true;
            }
        }
        document.getElementById('messageForm').addEventListener('submit', function(event) {
            console.log('Message form submitted');
        });
    </script>
</body>
</html>
