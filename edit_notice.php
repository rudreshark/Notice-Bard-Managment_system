<?php
session_start();
include('config.php');

if (!isset($_SESSION["loggedin"])) {
    exit("Access denied.");
}

$sql = "SELECT id, title, post_date FROM notices ORDER BY post_date DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Notices</title>
    <style>
        body {
            background: linear-gradient(135deg, #1c2938, #283e51);
            color: #f0f3f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 6px 18px rgba(0,0,0,0.6);
            border-radius: 10px;
            overflow: hidden;
            background-color: #2f3b4c;
        }
        th, td {
            text-align: left;
            padding: 12px 15px;
        }
        th {
            background-color: #f0ad4e;
            color: #1c2938;
            font-weight: 700;
        }
        tr:nth-child(even) {
            background-color: #34495e;
        }
        a.edit-link {
            color: #5dade2;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a.edit-link:hover {
            color: #f0ad4e;
        }
    </style>
</head>
<body>
    <h1>Manage Notices</h1>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Notice ID</th>
                    <th>Title</th>
                    <th>Posted On</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo date("F j, Y, g:i a", strtotime($row['post_date'])); ?></td>
                    <td><a class="edit-link" href="edit_notice.php?id=<?php echo urlencode($row['id']); ?>" target="main_content">Edit</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No notices found.</p>
    <?php endif; ?>
</body>
</html>
