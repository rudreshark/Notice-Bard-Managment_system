<?php
session_start();
include('config.php');

// Check if the user is logged in, if not, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<script>window.top.frames['main_content'].location.href = 'login.php';</script>";
    exit;
}


// Logic for logging out
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $_SESSION = array(); // Unset all session variables
    session_destroy();  // Destroy the session
    echo "<script>window.top.frames['main_content'].location.href = 'login.php';</script>";
    exit;
}


// Fetch notices for management display
$sql = "SELECT id, title, post_date FROM notices ORDER BY post_date DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: #f0f3f5;
            min-height: 100vh;
        }
        h2 {
            color: #f0ad4e;
            border-bottom: 3px solid #f0ad4e;
            padding-bottom: 10px;
            user-select: text;
        }
        .admin-nav {
            margin: 20px 0;
        }
        .admin-nav a {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 15px;
            background-color: #3498db;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.6);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .admin-nav a:hover {
            background-color: #2980b9;
            box-shadow: 0 6px 18px rgba(41, 128, 185, 0.8);
        }
        .admin-nav a.logout {
            background-color: #e74c3c !important;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.6);
        }
        .admin-nav a.logout:hover {
            background-color: #c0392b !important;
            box-shadow: 0 6px 18px rgba(192, 57, 43, 0.8);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(47, 59, 76, 0.85);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.75);
            font-size: 1rem;
        }
        th, td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #d4d8de;
            text-align: left;
        }
        th {
            background-color: #f0ad4e;
            color: #1c2938;
            font-weight: 700;
            user-select: none;
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
            cursor: pointer;
        }
        .action-links a {
            margin-right: 12px;
            color: #5dade2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .action-links a:hover {
            color: #f0ad4e;
        }
        .action-links a.delete {
            color: #e74c3c;
        }
        .action-links a.delete:hover {
            color: #c0392b;
        }

        @media (max-width: 720px) {
            body {
                margin: 15px;
            }

            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["fullname"]); ?>! (Admin Panel)</h2>
    <div class="admin-nav">
        <a href="push_notice.php" target="main_content">Push New Notice</a>
        <a href="admin.php?action=logout" target="_top" class="logout">Logout</a>
    </div>

    <h3>Manage Notices</h3>
    <?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Post Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo date("Y-m-d H:i", strtotime($row['post_date'])); ?></td>
                <td class="action-links">
                    <a href="edit_notice.php?id=<?php echo urlencode($row['id']); ?>" target="main_content">Edit</a> |
                    <a href="delete_notice.php?id=<?php echo urlencode($row['id']); ?>" target="main_content" class="delete" onclick="return confirm('Are you sure you want to delete this notice?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No notices currently posted.</p>
    <?php endif; ?>
</body>
</html>
