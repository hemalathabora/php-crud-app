<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "blog");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Blog App</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 40px; }
        h2 { text-align: center; }
        .topbar { text-align: center; margin-bottom: 20px; }
        .topbar a { margin: 0 10px; color: #3498db; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 0 8px #ccc; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        a.btn { padding: 6px 10px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; }
        a.btn-danger { background: #e74c3c; }
    </style>
</head>
<body>

<h2>📋 Welcome, <?php echo $_SESSION["username"]; ?>!</h2>

<div class="topbar">
    <a href="add_post.php" class="btn">➕ Add Post</a>
    <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
</div>

<table>
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row["title"]); ?></td>
        <td><?php echo htmlspecialchars(substr($row["content"], 0, 50)); ?>...</td>
        <td><?php echo $row["created_at"]; ?></td>
        <td>
            <a href="edit_post.php?id=<?php echo $row["id"]; ?>" class="btn">✏️ Edit</a>
            <a href="delete_post.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
