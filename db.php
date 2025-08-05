<?php
$host = "localhost";
$user = "kip";
$pass = "SPICEGlobal@1234";
$dbname = "powerbi";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    exit();
}

// No closing PHP tag, no echo, no space, no die()







