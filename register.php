<?php
$servername = "localhost";
$username = "zajaros";
$password = "andrej";
$dbname = "zajaros";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insertUser($conn, $meno, $heslo, $email) {
    $sql = $conn->prepare("INSERT INTO t_user (username, password, email) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $meno, $heslo, $email);
    if ($sql->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql->error;
    }
    $sql->close();
}

function checkUserExists($conn, $meno) {
    $sql = $conn->prepare("SELECT * FROM t_user WHERE username = ?");
    $sql->bind_param("s", $meno);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    return $result->num_rows > 0;
}

if (isset($_POST['submit'])) {
    $meno = $_POST['username'];
    $heslo = $_POST['password'];
    $hesloPotvrdit = $_POST['confirm_password'];
    $email = $_POST['email'];

    if ($heslo === $hesloPotvrdit) {
        if (!checkUserExists($conn, $meno)) {
            $hashedHeslo = password_hash($heslo, PASSWORD_DEFAULT);
            insertUser($conn, $meno, $hashedHeslo, $email);
        } else {
            $errorMessage = "User with this username already exists.";
        }
    } else {
        $errorMessage = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration form</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Montserrat', sans-serif; 
        background-color: #eaeaea; 
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .form-container {
        width: 350px;
        padding: 30px;
        border: 1px solid #d3d3d3;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
    input[type="text"],
    input[type="password"],
    input[type="email"] {
        width: 100%;
        padding: 12px;
        margin: 15px 0;
        box-sizing: border-box;
        border: 1px solid #bdbdbd;
        border-radius: 6px;
    }
    input[type="submit"] {
        width: 100%;
        background-color: #0d47a1; 
        color: white;
        padding: 16px 20px; 
        margin: 10px 0; 
        border: none;
        border-radius: 6px; 
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #0056b3; 
    }
    .error-message {
        color: #d32f2f; 
        margin-top: 15px; 
        text-align: center;
    }
    .form-container p {
        text-align: center;
        margin-top: 15px; 
    }
    .form-container a {
        text-decoration: none;
        color: #007bff; 
    }
    .form-container a:hover {
        text-decoration: underline;
    }
    .navbar {
        background-color: #002f6c;
        overflow: hidden;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .navbar a {
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }
    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }
    .navbar img {
        height: 50px;
        margin-right: 20px;
    }
</style>
</head>
<body>
<div class="navbar">
    <img src="https://www.hcslovan.sk/Upload/Gallery/Image/0,40904/custom/Screen_Shot_2021-05-25_at_16.09.34.png" alt="HC Slovan Logo">
    <a href="index.php">Home</a>
    <a href="welcome.php">Shop</a>
    <?php if(isset($_SESSION['username'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="register.php">Register</a>
        <a href="index.php">Login</a>
    <?php endif; ?>
</div>
<div class="form-container">
    <h2>Registration Form</h2>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username" required autofocus><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="submit" name="submit" value="Register">
    </form>
    <div class="error-message"><?php if(isset($errorMessage)) { echo $errorMessage; } ?></div>
    <p>Already registered? <a href="index.php">Login here</a>.</p>
</div>
</body>
</html>