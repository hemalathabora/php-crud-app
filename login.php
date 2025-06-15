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

    // Get user
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
        body { font-family: Arial; background: #f0f0f0; padding: 50px; }
        form { background: #fff; padding: 30px; border-radius: 8px; max-width: 400px; margin: auto; }
        input { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: #2ecc71; color: white; border: none; padding: 10px; width: 100%; }
        .msg { margin-top: 15px; color: red; }
    </style>
</head>
<body>

<h2 style="text-align:center;">🔐 Login</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <button type="submit">Login</button>
    <div class="msg"><?php echo $msg; ?></div>
</form>

</body>
</html>
