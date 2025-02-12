<?php
$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    include 'db_connection.php'; 
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM student WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $message = "Login successful!";
        $message_color = "green";
    } else {
        $message = "Invalid username or password.";
        $message_color = "red";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background: linear-gradient(to right,rgb(35, 34, 56),rgb(13, 17, 51)); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            flex-direction: column;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
            width: 300px;
            font-size: 16px;
            font-weight: bold;
            color: <?php echo isset($message_color) ? $message_color : 'black'; ?>;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color:rgb(41, 39, 94);
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

<?php if (!empty($message)): ?>
    <div class="message-box">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

    <div class="login-container">
        <form action="login.php" method="post">
            <h2>Login</h2>
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>

</body>
</html>
