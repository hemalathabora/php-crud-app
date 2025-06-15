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

$post_id = $_GET["id"] ?? null;
if (!$post_id) {
    echo "Invalid post ID.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Post not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    $update = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $update->bind_param("ssi", $title, $content, $post_id);
    $update->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post - Blog App</title>
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
            background: #2980b9;
            color: white;
            padding: 12px 20px;
            border: none;
            margin-top: 25px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #216a94;
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
    <h2>✏️ Edit Post</h2>

    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

        <label>Content:</label>
        <textarea name="content" rows="8" required><?php echo htmlspecialchars($post['content']); ?></textarea>

        <button type="submit">Update Post</button>
    </form>

    <a href="dashboard.php">⬅️ Back to Dashboard</a>
</div>

</body>
</html>
