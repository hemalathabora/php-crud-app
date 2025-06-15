<?php
// Start session
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "blog");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

// Handle form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Insert user
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
        body { font-family: Arial; background: #f2f2f2; padding: 50px; }
        form { background: #fff; padding: 30px; border-radius: 8px; max-width: 400px; margin: auto; }
        input { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: #3498db; color: white; border: none; padding: 10px; width: 100%; }
        .msg { margin-top: 15px; color: green; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📝 Register</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <button type="submit">Register</button>
    <div class="msg"><?php echo $msg; ?></div>
</form>

</body>
</html>
