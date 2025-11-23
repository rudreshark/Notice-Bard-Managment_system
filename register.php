<?php
include('config.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Please fill in all fields.";
    } elseif ($password != $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_fullname, $param_email, $param_password);
            $param_fullname = $fullname;
            $param_email = $email;
            $param_password = $hashed_password;
            if (mysqli_stmt_execute($stmt)) {
                $message = "<span style='color:#5cb85c; font-weight: 600;'>Registration successful!</span> You can now <a href='login.php' target='main_content' style='color:#5dade2; text-decoration:none;'>login</a>.";
            } else {
                $message = "Error: Email already in use or database error.";
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
    <title>Register</title>
    <style>
        /* Dark gradient background for professional look */
        body {
            background: linear-gradient(135deg, #1c2938, #283e51);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #f0f3f5;
        }

        /* Container design with depth and rounded corners */
        .form-container {
            background-color: #2f3b4c;
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
            width: 400px;
            box-sizing: border-box;
        }

        /* Header with accent gold color */
        h2 {
            margin: 0 0 30px 0;
            color: #f0ad4e;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: 2px;
            user-select: text;
        }

        /* Message styling with spacing */
        .message {
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            user-select: none;
        }

        /* Inputs styling consistent with theme */
        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 14px 18px;
            margin: 10px 0 25px 0;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: #415268;
            color: #e1e8f0;
            transition: background-color 0.3s ease;
        }

        /* Focus effect on inputs */
        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="password"]:focus {
            background-color: #5dade2;
            outline: none;
            color: #1c2938;
            font-weight: 600;
        }

        /* Button styling with glow effect */
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

        /* Button hover effect */
        button:hover {
            background-color: #d6981e;
            box-shadow: 0 8px 24px rgba(214, 152, 30, 0.9);
            color: #ffffff;
        }

        /* Responsive adjustments */
        @media (max-width: 440px) {
            .form-container {
                width: 90%;
                padding: 30px 20px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container" role="main" aria-label="Registration form">
        <h2>Register</h2>
        <?php if (!empty($message)) echo "<p class='message'>" . $message . "</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <input type="text" name="fullname" placeholder="Full Name" required aria-required="true" autocomplete="name" />
            <input type="email" name="email" placeholder="Email (Used as Username)" required aria-required="true" autocomplete="email" />
            <input type="password" name="password" placeholder="Password" required aria-required="true" autocomplete="new-password" />
            <input type="password" name="confirm_password" placeholder="Confirm Password" required aria-required="true" autocomplete="new-password" />
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
