<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "blog");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

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
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #ecf0f1;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 700px;
            background: white;
            margin: 60px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        label {
            display: block;
            margin-top: 20px;
            color: #333;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            background: #27ae60;
            color: white;
            padding: 12px 20px;
            border: none;
            margin-top: 25px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #219150;
        }
        .msg {
            color: green;
            margin-top: 15px;
            font-weight: bold;
        }
        a {
            display: block;
            margin-top: 25px;
            text-align: center;
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📝 Add New Post</h2>

    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Content:</label>
        <textarea name="content" rows="8" required></textarea>

        <button type="submit">Publish</button>
        <div class="msg"><?php echo $msg; ?></div>
    </form>

    <a href="dashboard.php">⬅️ Back to Dashboard</a>
</div>

</body>
</html>
