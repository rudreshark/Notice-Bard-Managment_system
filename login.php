<?php
// Start session and include config first
session_start();
include('config.php');

// Redirect to admin page if already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}

$message = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Prepare a select statement
    $sql = "SELECT id, fullname, email, password FROM users WHERE email = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            // Check if email exists, then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){                      
                mysqli_stmt_bind_result($stmt, $id, $fullname, $email, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        // Password is correct, start a new session
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["fullname"] = $fullname;
                        $_SESSION["email"] = $email;                              
                        
                        // Redirect to admin page
                        echo "<script>window.top.frames['main_content'].location.href = 'admin.php';</script>";
                        exit;
                    } else{
                        $message = "The password you entered was not valid.";
                    }
                }
            } else{
                $message = "No account found with that email.";
            }
        } else{
            $message = "Oops! Something went wrong. Please try again later.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login</title>
    <style>
        /* Base style */
        body {
            background: linear-gradient(135deg, #283e51, #1c2938);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #f0f3f5;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: #2f3b4c;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
            width: 350px;
            box-sizing: border-box;
        }

        h2 {
            margin: 0 0 30px 0;
            color: #f0ad4e;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: 2px;
            user-select: text;
        }
         
        .message {
            background-color: #d9534f;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 3px 8px rgba(217, 83, 79, 0.5);
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0 20px 0;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: #415268;
            color: #e1e8f0;
            transition: background-color 0.3s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            background-color: #5dade2;
            outline: none;
            color: #1c2938;
            font-weight: 600;
        }

        button {
            width: 100%;
            background-color: #f0ad4e;
            color: #1c2938;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(240, 173, 78, 0.6);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #d6981e;
            box-shadow: 0 8px 24px rgba(214, 152, 30, 0.9);
            color: #ffffff;
        }

        /* Responsive for small screens */
        @media (max-width: 400px) {
            .form-container {
                width: 90%;
                padding: 30px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container" role="main" aria-label="Admin login form">
        <h2>Admin Login</h2>
        <?php if (!empty($message)) echo "<p class='message'>" . htmlspecialchars($message) . "</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="email" name="email" placeholder="Email" required aria-required="true" autocomplete="username" />
            <input type="password" name="password" placeholder="Password" required aria-required="true" autocomplete="current-password" />
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
