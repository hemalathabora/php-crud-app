<?php
session_start();

// Connect to DB
$conn = new mysqli("localhost", "root", "", "blog");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "❌ Invalid password.";
        }
    } else {
        $msg = "❌ Username not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Blog App</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #a29bfe, #81ecec);
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
            background: #2ecc71;
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
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔐 Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
        <div class="msg"><?php echo $msg; ?></div>
    </form>
</div>

</body>
</html>
