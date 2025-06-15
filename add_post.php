<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// DB connection
$conn = new mysqli("localhost", "root", "", "blog");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

// Handle post submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    $sql = "INSERT INTO posts (title, content, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();

    $msg = "✅ Post added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post - Blog App</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 40px; }
        form { background: #fff; padding: 20px; max-width: 600px; margin: auto; border-radius: 8px; box-shadow: 0 0 8px #ccc; }
        input, textarea { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: #27ae60; color: white; padding: 10px 20px; border: none; margin-top: 15px; }
        a { text-decoration: none; color: #3498db; display: inline-block; margin-top: 20px; }
        .msg { color: green; margin-top: 10px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📝 Add New Post</h2>

<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Content:</label>
    <textarea name="content" rows="6" required></textarea>

    <button type="submit">Publish</button>
    <div class="msg"><?php echo $msg; ?></div>
</form>

<a href="dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
