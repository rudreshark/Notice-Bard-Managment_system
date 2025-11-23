<?php
session_start();
include('config.php');
if(!isset($_SESSION["loggedin"])) exit; // Security check

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if (empty($title) || empty($content)) {
        $message = "<span class='error'>Please fill in both title and content.</span>";
    } else {
        $sql = "INSERT INTO notices (title, content) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_content);
            $param_title = $title;
            $param_content = $content;
            
            if (mysqli_stmt_execute($stmt)) {
                $message = "<span class='success'>Notice successfully posted!</span> <a href='admin.php' target='main_content'>Go back to Admin Panel.</a>";
            } else {
                $message = "<span class='error'>Error posting notice: " . htmlspecialchars(mysqli_error($conn)) . "</span>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Push Notice</title>
    <style>
        /* Dark gradient background for professional feel */
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #283e51, #1c2938);
            color: #f0f3f5;
        }

        /* Form container with shadows and rounded corners */
        .form-container {
            background-color: #2f3b4c;
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.6);
            width: 400px;
            box-sizing: border-box;
            user-select: none;
        }

        /* Heading style with brand accent */
        h2 {
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 700;
            color: #f0ad4e;
            text-align: center;
            letter-spacing: 2px;
            user-select: text;
        }

        /* Message styles */
        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .success {
            color: #5cb85c;
        }
        .error {
            color: #d9534f;
        }

        /* Input and textarea styling */
        input[type="text"],
        textarea {
            width: 100%;
            background-color: #415268;
            border: none;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 25px;
            font-size: 1rem;
            color: #e1e8f0;
            box-sizing: border-box;
            resize: vertical;
            transition: background-color 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            background-color: #5dade2;
            outline: none;
            color: #1c2938;
            font-weight: 600;
        }

        /* Button styling with glowing effect */
        button {
            width: 100%;
            background-color: #f0ad4e;
            color: #1c2938;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 14px 20px;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(240,173,78,0.6);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        button:hover {
            background-color: #d6981e;
            box-shadow: 0 8px 24px rgba(214,152,30,0.9);
            color: #ffffff;
        }

        /* Responsive layout */
        @media (max-width: 440px) {
            .form-container {
                width: 90%;
                padding: 30px 20px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }

        /* Link styling inside success message */
        a {
            color: #5dade2;
            text-decoration: none;
            font-weight: 600;
            transition: text-decoration 0.3s ease;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container" role="main" aria-label="Push new notice form">
        <h2>Push New Notice</h2>
        <?php if (!empty($message)) echo "<p class='message'>{$message}</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <input type="text" name="title" placeholder="Notice Title" required aria-required="true" autocomplete="off" />
            <textarea name="content" placeholder="Notice Content" rows="6" required aria-required="true"></textarea>
            <button type="submit">Publish Notice</button>
        </form>
    </div>
</body>
</html>
