<?php
session_start();
require_once 'db.php';
date_default_timezone_set('Africa/Nairobi');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Organization access control
$org = $_SESSION['organization'] ?? '';
if (stripos($org, 'Sierra Leone') === false && stripos($org, 'Medtronic Labs') === false) {
    // Redirect unauthorized users to the main reports page
    header('Location: reports.php');
    exit;
}

// Log page access
function logPageAccess($pageName, $conn) {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $timestamp = date('Y-m-d H:i:s');
        $sql = "INSERT INTO users_page_visits (user_id, page_name, access_time) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("iss", $userId, $pageName, $timestamp);
            $stmt->execute();
            $stmt->close();
        } else {
            error_log('SQL prepare failed: ' . $conn->error);
        }
    }
}

logPageAccess('Sierra Leone Dashboard', $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sierra Leone Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/images/comemr.png">

  <!-- Microsoft Clarity Tracking Code -->
  <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "s7ifpngdg7");
  </script>

  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
    }
    header {
      text-align: center;
      padding: 10px;
    }
    iframe {
      width: 100%;
      height: calc(100% - 80px);
      border: none;
    }
    .logout-btn {
      position: fixed;
      top: 10px;
      right: 10px;
      background-color: #00338D;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
    }
    .logout-btn:hover {
      background-color: #0055cc;
    }
  </style>
</head>
<body>
  <header>
    <img src="/images/comemr.png" alt="COMEMR Logo" style="max-height:60px;">
  </header>
    <a href="logout.php" class="logout-btn">Logout</a>
  <iframe src="https://app.powerbi.com/view?r=eyJrIjoiMmUwNzllZTItY2U5OC00MWU5LWJiOGItNjMwMTgyY2Q2NzQzIiwidCI6IjcyOWIwNWQ5LTI0NDQtNDI5YS1iM2M4LTdjNWJiZWQ2MjVkOCJ9" allowFullScreen="true"></iframe>
</body>
</html>
