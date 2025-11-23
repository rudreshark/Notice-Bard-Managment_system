<?php
// Include the database config
include('config.php');
session_start(); // Start session for user/admin checks
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Current Notices</title>
    <style>
        body {
            /* New vibrant blue gradient background with subtle texture */
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
            background-image: url('https://www.transparenttextures.com/patterns/asfalt-light.png'), 
                              linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
            background-repeat: repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            color: #f0f3f5;
            min-height: 100vh;
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #f0ad4e;
            border-bottom: 3px solid #f0ad4e;
            padding-bottom: 10px;
            user-select: text;
            max-width: fit-content;
            margin-bottom: 30px;
        }

        .notice {
            background-color: #2f3b4c;
            border-radius: 12px;
            padding: 20px 25px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.6);
            transition: transform 0.3s ease;
        }

        .notice:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(240, 173, 78, 0.9);
        }

        .notice h3 {
            margin-top: 0;
            color: #5dade2;
            font-weight: 700;
            font-size: 1.4rem;
            user-select: text;
        }

        .notice p {
            font-size: 1rem;
            color: #d1d9e6;
            line-height: 1.6;
            white-space: pre-wrap;
        }

        .notice em {
            display: block;
            margin-top: 15px;
            font-size: 0.85rem;
            color: #a0aec0;
        }

        p.no-notices {
            font-size: 1rem;
            color: #bbb3b9ff;
            text-align: center;
            margin-top: 50px;
            user-select: none;
        }
        .mail{
            color: #e9d4e9ff;
            font-size:150%;


        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            body {
                margin: 15px;
            }

            .notice {
                padding: 15px 20px;
            }

            h2 {
                font-size: 1.5rem;
                margin-bottom: 20px;
            }

            .notice h3 {
                font-size: 1.2rem;
            }

            .notice p {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

<?php
// Handle simple static pages (About Us, Contact Us, Help)
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page === 'about') {
        echo '<h2>About Us</h2><p>Our NoticeBoard System is designed to streamline communication across organizations by providing a centralized platform for posting and managing important notices. It enables users to easily share updates, announcements, and essential information in a secure and organized manner. The system is built with simplicity and efficiency in mind, ensuring that both administrators and users can navigate and utilize its features with ease. By facilitating timely and transparent communication, our NoticeBoard System helps keep everyone informed and connected.

</p>';
    } elseif ($page === 'contact') {
        echo '<h2>Contact Us</h2><p>Our support team is dedicated to assisting you with any questions or issues related to the NoticeBoard System. For inquiries, technical support, or feedback, please contact us via email at admin@noticeboard.com. We strive to provide timely and effective responses to ensure your experience with our system is smooth and productive. Your communication is important to us, and we are here to help you make the most of the platform.</p>';
    } elseif ($page === 'help') {
        echo '<h2>Help</h2><p>If you need assistance using the NoticeBoard System, please refer to the Help section for guidance on navigating and utilizing its features. The Help section provides step-by-step instructions for common tasks such as logging in, posting notices, and managing user accounts. Should you encounter any difficulties, the Help resources are designed to offer clear solutions quickly. For further support, you can always contact our support team who are ready to assist you.<br><a href="admin@noticeboard.com" class="mail">admin@noticeboard.com</a></p>';
    }
}
?>

<h2>Current Notices</h2>

<?php
$sql = "SELECT title, content, post_date FROM notices ORDER BY post_date DESC";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='notice'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<em>Posted: " . date("F j, Y, g:i a", strtotime($row['post_date'])) . "</em>";
        echo "</div>";
    }
} else {
    echo "<p class='no-notices'>No notices available yet.</p>";
}
?>

</body>
</html>
