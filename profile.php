<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
        .profile-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .profile-details {
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .profile-details input, .profile-details textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .profile-details button {
            padding: 10px 20px;
            background: #0073b1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .profile-details button:hover {
            background: #005f8d;
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
    $query = "SELECT * FROM users WHERE id = $1";
    $result = pg_query_params($conn, $query, [$user_id]);
    if (!$result || pg_num_rows($result) === 0) {
        error_log("Error fetching user: " . pg_last_error($conn));
        echo "<script>alert('User not found.'); window.location.href = 'login.php';</script>";
        exit;
    }
    $user = pg_fetch_assoc($result);
    ?>
    <div class="navbar">
        <a href="index.php" onclick="return navigate('index.php')">Home</a>
        <a href="profile.php" onclick="return navigate('profile.php')">Profile</a>
        <a href="jobs.php" onclick="return navigate('jobs.php')">Jobs</a>
        <a href="messages.php" onclick="return navigate('messages.php')">Messages</a>
    </div>
    <div class="container">
        <div class="profile-header">
            <img src="default-profile.png" alt="Profile Picture">
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
            <p><?php echo htmlspecialchars($user['job_title'] ?? 'Update your job title'); ?></p>
        </div>
        <div class="profile-details">
            <h3>Edit Profile</h3>
            <form id="profileForm" action="update_profile.php" method="POST">
                <input type="text" name="job_title" placeholder="Job Title" value="<?php echo htmlspecialchars($user['job_title'] ?? ''); ?>">
                <textarea name="summary" placeholder="Summary"><?php echo htmlspecialchars($user['summary'] ?? ''); ?></textarea>
                <input type="text" name="education" placeholder="Education" value="<?php echo htmlspecialchars($user['education'] ?? ''); ?>">
                <input type="text" name="experience" placeholder="Experience" value="<?php echo htmlspecialchars($user['experience'] ?? ''); ?>">
                <input type="text" name="skills" placeholder="Skills" value="<?php echo htmlspecialchars($user['skills'] ?? ''); ?>">
                <button type="submit">Save</button>
            </form>
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
        document.getElementById('profileForm').addEventListener('submit', function(event) {
            console.log('Profile form submitted');
        });
    </script>
</body>
</html>
