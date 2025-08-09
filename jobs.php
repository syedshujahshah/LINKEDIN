<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
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
        .job-form, .job-list {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .job-form input, .job-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .job-form button {
            padding: 10px 20px;
            background: #0073b1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .job-form button:hover {
            background: #005f8d;
        }
        .job-list .job {
            padding: 10******/
/* content truncated for brevity */
            border-bottom: 1px solid #ddd;
        }
        .job button {
            padding: 10px 20px;
            background: #0073b1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .job button:hover {
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
    $query = "SELECT * FROM jobs";
    $result = pg_query($conn, $query);
    if (!$result) {
        error_log("Error fetching jobs: " . pg_last_error($conn));
        echo "<script>alert('Error loading jobs. Please try again.'); window.location.href = 'index.php';</script>";
        exit;
    }
    $jobs = pg_fetch_all($result);
    ?>
    <div class="navbar">
        <a href="index.php" onclick="return navigate('index.php')">Home</a>
        <a href="profile.php" onclick="return navigate('profile.php')">Profile</a>
        <a href="jobs.php" onclick="return navigate('jobs.php')">Jobs</a>
        <a href="messages.php" onclick="return navigate('messages.php')">Messages</a>
    </div>
    <div class="container">
        <div class="job-form">
            <h2>Post a Job</h2>
            <form id="jobForm" action="post_job.php" method="POST">
                <input type="text" name="title" placeholder="Job Title" required>
                <input type="text" name="location" placeholder="Location" required>
                <input type="text" name="industry" placeholder="Industry" required>
                <textarea name="description" placeholder="Job Description" required></textarea>
                <button type="submit">Post Job</button>
            </form>
        </div>
        <div class="job-list">
            <h2>Available Jobs</h2>
            <?php if ($jobs): ?>
                <?php foreach ($jobs as $job): ?>
                    <div class="job">
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p>Location: <?php echo htmlspecialchars($job['location']); ?></p>
                        <p>Industry: <?php echo htmlspecialchars($job['industry']); ?></p>
                        <p><?php echo htmlspecialchars($job['description']); ?></p>
                        <button onclick="applyJob(<?php echo $job['id']; ?>)">Apply</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No jobs available.</p>
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
        function applyJob(jobId) {
            alert('Applied for job ' + jobId);
        }
        document.getElementById('jobForm').addEventListener('submit', function(event) {
            console.log('Job form submitted');
        });
    </script>
</body>
</html>
