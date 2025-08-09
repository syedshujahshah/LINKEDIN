<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkedIn Clone - Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #e8f4f8;
            color: #333;
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
        .post-feed {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .post {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .job-listing {
            background: #e8f4f8;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .trending {
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .button {
            padding: 10px 20px;
            background: #0073b1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .button:hover {
            background: #005f8d;
        }
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            .navbar {
                flex-direction: column;
            }
            .navbar a {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php" onclick="return navigate('index.php')">Home</a>
        <a href="profile.php" onclick="return navigate('profile.php')">Profile</a>
        <a href="jobs.php" onclick="return navigate('jobs.php')">Jobs</a>
        <a href="messages.php" onclick="return navigate('messages.php')">Messages</a>
        <a href="login.php" onclick="return navigate('login.php')">Login</a>
        <a href="signup.php" onclick="return navigate('signup.php')">Sign Up</a>
    </div>
    <div class="container">
        <h1>Welcome to Professional Network</h1>
        <div class="post-feed">
            <h2>Recent Posts</h2>
            <div class="post">
                <p><strong>John Doe</strong>: Excited to start my new role at Tech Corp!</p>
                <button class="button" onclick="likePost(1)">Like</button>
                <button class="button" onclick="commentPost(1)">Comment</button>
            </div>
        </div>
        <div class="job-listing">
            <h3>Job Openings</h3>
            <p>Software Engineer at Tech Corp - Lahore, PK</p>
            <button class="button" onclick="navigate('jobs.php')">View More</button>
        </div>
        <div class="trending">
            <h3>Trending Articles</h3>
            <p>How AI is Transforming the Workplace</p>
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
        function likePost(postId) {
            alert('Liked post ' + postId);
        }
        function commentPost(postId) {
            alert('Comment on post ' + postId);
        }
    </script>
</body>
</html>
