<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .signup-container h2 {
            text-align: center;
            color: #0073b1;
        }
        .signup-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .signup-container button {
            width: 100%;
            padding: 10px;
            background: #0073b1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .signup-container button:hover {
            background: #005f8d;
        }
        .signup-container a {
            color: #0073b1;
            text-decoration: none;
        }
        .signup-container a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .signup-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form id="signupForm" action="signup_process.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php" onclick="return navigate('login.php')">Login</a></p>
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
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            console.log('Signup form submitted');
        });
    </script>
</body>
</html>
