<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$org = $_SESSION['organization'] ?? '';
$links = [];

if ($org === 'Medtronic Labs') {
    $links = [
        ['HRIO.php', 'HRIO Report'],
        ['dqa.php', 'County Led DQA'],
        ['Novo.php', 'NOVO'],
        ['org.php', 'MDTLabs Impact Metrics'],
        ['sl.php', 'Sierra Leone Reports']
    ];
} elseif ($org === 'Ministry of Health') {
    $links = [
        ['HRIO.php', 'HRIO Report']
    ];
} elseif ($org === 'Kenya Diabetes Management & Information Centre') {
    $links = [
        ['dqa.php', 'County Led DQA']
    ];
} elseif ($org === 'Sierra Leone') {
    $links = [
        ['sl.php', 'Sierra Leone Reports']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/fav.png">
    <title>Report Access</title>
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
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .box {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 250px;
            padding: 15px;
            text-align: center;
        }
        .box img {
            max-width: 100%;
            border-radius: 10px;
        }
        .box a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00338D;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .box a:hover {
            background-color: #0055cc;
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
    <h2 style="text-align:center;">Access Reports</h2>
    <div class="container">
        <?php if (!empty($links)): ?>
            <?php foreach ($links as $link): ?>
                <div class="box">
                    <img src="/images/img1.png" alt="Report Image">
                    <a href="<?php echo $link[0]; ?>" target="_blank"><?php echo $link[1]; ?></a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reports available for your organization.</p>
        <?php endif; ?>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>
    <script>
        // Optional: Add a click event to the logout button
        document.querySelector('.logout-btn').addEventListener('click', function() {
            window.location.href = 'logout.php';
        });
    </script>
</div>
</body>
</html>

