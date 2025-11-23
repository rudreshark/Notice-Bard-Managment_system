# NoticeBoard System

## Description

The NoticeBoard System is a simple, web-based platform for posting, viewing, and managing notices, suitable for schools, businesses, and organizations. It provides an admin panel for notice management (creation, editing, deletion), secure admin login, user registration, and a publicly accessible board for current notices. The system uses PHP and MySQL for backend, with a modern and responsive interface. 

### Features

- **Admin Panel**: Manage notices with edit and delete options.
- **User Authentication**: Secure admin login, registration mechanism for users.
- **Push New Notices**: Admins can publish new notices easily.
- **Responsive UI**: The interface adapts to mobile and desktop screens.
- **Public Display**: All users can view current notices and helpful information.
- **Safe Data Storage**: Uses MySQL for storing user and notice data.
- **Simple Installation**: Easily set up with standard PHP and MySQL server (XAMPP, WAMP, LAMP compatible).
- **Accessibility**: Keyboard navigation, screen reader-friendly elements.

---

## Installation

### Prerequisites

- **Web Server**: Apache/Nginx (recommend [XAMPP](https://www.apachefriends.org/), [WAMP](https://www.wampserver.com/), or LAMP stack)
- **PHP**: Version 7.4 or newer
- **MySQL**: Version 5.7 or newer
- If you use XAMPP or WAMP, the default settings will work.
- Web browser (Chrome, Firefox, Edge, etc.)

### Steps

#### 1. Clone/download the repository

```bash
git clone https://github.com/YOUR_USERNAME/YOUR_REPOSITORY_NAME.git
```
Or download and extract the ZIP archive.

#### 2. Place files in your web root

- Copy all files (`.php` and `.html`) into your web server's public directory.
    - For XAMPP, it's usually `C:\xampp\htdocs\NoticeBoardSystem`
    - For Linux with Apache, it's `/var/www/html/NoticeBoardSystem`

#### 3. Create the Database

- Start your MySQL server.
- Open phpMyAdmin or use MySQL CLI and run:

```sql
CREATE DATABASE noticeboard_db;
USE noticeboard_db;

-- Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(256) NOT NULL
);

-- Create Notices Table
CREATE TABLE notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(256) NOT NULL,
    content TEXT NOT NULL,
    post_date DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### 4. Configure Database Settings

- Open `config.php` in an editor.
- Check these lines:
    ```php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root'); // XAMPP default
    define('DB_PASSWORD', '');     // XAMPP default (empty)
    define('DB_NAME', 'noticeboard_db');
    ```
- **Change these settings** if your MySQL login is different (for WAMP/LAMP/Raspberry Pi, you may need a password).

#### 5. Start the Server

- For XAMPP/WAMP, start Apache and MySQL from the control panel.
- For Linux, start services:
    ```bash
    sudo service apache2 start
    sudo service mysql start
    ```
- Visit: `http://localhost/NoticeBoardSystem/index.html` in your browser.

#### 6. Register the first admin

- Click "Register" and fill in your details.
- Login using the credentials and manage notices.

#### 7. You're Ready!

---

## Platform Support

- **Windows** – XAMPP, WAMP
- **Linux (Debian/Ubuntu/CentOS, etc.)** – LAMP or direct Apache/MySQL install
- **macOS** – MAMP or direct Apache/MySQL/PHP install

Works anywhere PHP and MySQL are functioning and the files are accessible via web server.

---

## Security Note
- Change MySQL root password for production installations.
- For internet-facing deployments, further harden with HTTPS, rate limiting, and stronger session management.

---

## License

MIT License

---

## Credits

Developed by Rudresha rk. For questions or support, email: alexaalex111990@gmail.com
