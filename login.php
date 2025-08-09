<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            color: #0073b1;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background: #0073b1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
            background: #005f8d;
        }
        .login-container a {
            color: #0073b1;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .login-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" action="login_process.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php" onclick="return navigate('signup.php')">Sign Up</a></p>
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
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            console.log('Login form submitted');
        });
    </script>
</body>
</html>
