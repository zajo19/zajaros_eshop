<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["valid"]);
header('Refresh: 2; URL = index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Logout</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
<style>
   body {
    font-family: 'Montserrat', sans-serif; 
    background-color: #a3c1da; 
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    text-align: center;
}
</style>
</head>
<body>
    <h2>You have logged out. Redirecting to login page...</h2>
</body>
</html>