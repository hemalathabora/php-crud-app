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

// Fetch post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Post not found.";
    exit();
}

// Update post
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
    <title>Edit Post</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f4f4f4; }
        form { background: #fff; padding: 20px; max-width: 600px; margin: auto; border-radius: 8px; box-shadow: 0 0 8px #ccc; }
        input, textarea { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: #2980b9; color: white; padding: 10px 20px; border: none; margin-top: 15px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">✏️ Edit Post</h2>

<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

    <label>Content:</label>
    <textarea name="content" rows="6" required><?php echo htmlspecialchars($post['content']); ?></textarea>

    <button type="submit">Update Post</button>
</form>

</body>
</html>
