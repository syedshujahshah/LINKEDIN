<?php
$host = 'db';
$port = '5432';
$dbname = 'dba51pgjkj8v8y';
$user = 'uac1gp3zeje8t';
$password = 'hk8ilpc7us2e';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    error_log("Database connection failed: " . pg_last_error());
    die("<script>alert('Database connection failed. Please check server logs.'); window.location.href = 'index.php';</script>");
}
?>
