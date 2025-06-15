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

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Blog App</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f4f8;
            padding: 40px;
            margin: 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .topbar {
            text-align: center;
            margin-bottom: 30px;
        }
        .topbar a {
            margin: 0 10px;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
            display: inline-block;
            transition: background 0.3s ease;
        }
        .btn {
            background-color: #3498db;
            color: white;
            text-decoration: none;
             border-radius: 8px;
        }
        .btn-danger {
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
             border-radius: 8px;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 16px 20px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #f7f9fc;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td .btn, td .btn-danger {
            font-size: 14px;
            padding: 8px 14px;
        }
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
            <a href="delete_post.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
