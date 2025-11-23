<?php
session_start();
include('config.php');
if(!isset($_SESSION["loggedin"])) exit; // Security check

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $notice_id = $_GET['id'];
    
    $sql = "DELETE FROM notices WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $notice_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "<span class='success'>Notice ID $notice_id deleted successfully!</span>";
        } else {
            $message = "<span class='error'>Error deleting record: " . htmlspecialchars(mysqli_error($conn)) . "</span>";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    $message = "<span class='error'>Invalid notice ID.</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Delete Result</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #1c2938, #283e51);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #f0f3f5;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .container {
            background-color: #2f3b4c;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.7);
            max-width: 450px;
            width: 90%;
            box-sizing: border-box;
            user-select: none;
        }

        .message {
            font-size: 1.3rem;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .success {
            color: #5cb85c;
        }

        .error {
            color: #d9534f;
        }

        a {
            display: inline-block;
            font-size: 1rem;
            color: #5dade2;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 25px;
            background-color: #34495e;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(93, 173, 226, 0.5);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            user-select: text;
        }

        a:hover {
            background-color: #5dade2;
            color: #1c2938;
            box-shadow: 0 8px 28px rgba(93, 173, 226, 0.8);
        }
    </style>
</head>
<body>
    <div class="container" role="main" aria-live="polite" aria-atomic="true">
        <div class="message">
            <?php echo $message; ?>
        </div>
        <a href="admin.php" target="main_content" aria-label="Return to Admin Panel">Return to Admin Panel</a>
    </div>
</body>
</html>
