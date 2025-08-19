<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

$error = "";
$remembered = isset($_COOKIE['remembered_user']) ? $_COOKIE['remembered_user'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rawInput = trim($_POST['identifier']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Clean phone number (remove anything that's not a digit)
    $cleanedPhone = preg_replace('/\D/', '', $rawInput);

    // Basic check if input is a phone number (Kenyan 07XXXXXXXX or 2547XXXXXXXX)
    $isPhone = preg_match('/^(07\d{8}|2547\d{8})$/', $cleanedPhone);

    $sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        if ($isPhone) {
            $dummyEmail = ''; // not used
            $stmt->bind_param("ss", $dummyEmail, $cleanedPhone);
        } else {
            $dummyPhone = ''; // not used
            $stmt->bind_param("ss", $rawInput, $dummyPhone);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

<<<<<<< HEAD
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['organization'] = $user['organization'];
=======
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['organization'] = $user['organization'];
>>>>>>> 12bb2faea17ffaea067650226afc6a085b73a852

            if ($remember) {
                setcookie("remembered_user", $rawInput, time() + (86400 * 60), "/");
            } else {
                setcookie("remembered_user", "", time() - 3600, "/");
            }

            // Log login
            $login_time = date('Y-m-d H:i:s');
            $log_sql = "INSERT INTO users_login_logs (user_id, login_time) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("is", $user['id'], $login_time);
            $log_stmt->execute();

<<<<<<< HEAD
            header("Location: reports.php");
=======
            header("Location: reports.php");
>>>>>>> 12bb2faea17ffaea067650226afc6a085b73a852
            exit();
        } else {
            $error = "Invalid email or phone number or password. <a href='forgot-password.php'>Forgot password?</a>";
        }
    } else {
        $error = "Database error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Login SPICE INSIGHTS</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="/images/fav.png">

    <!-- Microsoft Clarity Tracking Code -->
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "s7ifpngdg7");
    </script>
</head>
<<<<<<< HEAD
<body class="login-page">
    <div class="form-container">
        <img src="images/fav.png" alt="Logo" class="logo">
        <h2>Login</h2>
=======
<body class="login-page">
    <div class="form-container">
        <img src="images/fav.png" alt="Logo" class="logo">
        <h2>Login</h2>
>>>>>>> 12bb2faea17ffaea067650226afc6a085b73a852

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="identifier">Email or Phone</label>
            <input 
                type="text" 
                name="identifier" 
                placeholder="Phone Number / user@gmail.com " 
                value="<?php echo htmlspecialchars($remembered); ?>" 
                required
            >
            <label for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                placeholder="Password" 
                required
            >

            <label style="display: flex; align-items: center; gap: 2px; margin: 6px 0; white-space: nowrap;">
              Remember Me
	      <input 
                 type="checkbox" 
                 name="remember"
                 id="remember"
                <?php echo $remembered ? 'checked' : ''; ?>
                >
              </label>

            <button type="submit">Login</button>
        </form>

        <p>New user? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>




