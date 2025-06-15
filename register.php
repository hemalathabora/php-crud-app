<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

// Handle form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $msg = "✅ Registration successful. <a href='login.php'>Login here</a>";
    } else {
        $msg = "❌ Error: Username might already exist.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Blog App</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #dff9fb, #f6e58d);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        .msg {
            margin-top: 20px;
            color: #27ae60;
            text-align: center;
        }
        a {
            color: #2980b9;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📝 Register</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Register</button>
        <div class="msg"><?php echo $msg; ?></div>
    </form>
</div>

</body>
</html>
