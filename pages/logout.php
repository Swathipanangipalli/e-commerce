<?php
session_start();
session_unset();
session_destroy();
header("Refresh: 3; url=login.php"); // fallback server-side redirect
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging Out...</title>
    <meta http-equiv="refresh" content="3;url=login.php">
    <style>
        body {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
        }
        .message-box {
            background-color: #ffffff;
            padding: 30px 40px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .message-box h2 {
            color: #28a745;
            margin-bottom: 10px;
        }
        .message-box p {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h2>Logout Successful</h2>
        <p>Redirecting you to the login page...</p>
    </div>
</body>
</html>

<a href="pages/logout.php">Logout</a>


