<?php
session_start();
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $servername = "localhost";
    $username = "zajaros";
    $password = "andrej";
    $dbname = "zajaros";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT password FROM t_user WHERE username = '".$_POST['username']."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($_POST['password'], $row["password"])) {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $_POST['username'];

            header("Location: welcome.php", true, 301);
            exit();
        } else {
            $error_message = "Wrong password";
        }
    } else {
        $error_message = "Wrong username";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
<title>Login Form</title>
<style>
   body {
       font-family: 'Montserrat', sans-serif; 
       background-color: #0d47a1; 
       color: white;
       display: flex;
       flex-direction: column;
       justify-content: center;
       align-items: center;
       height: 100vh;
       margin: 0;
   }
   form {
       width: 400px; 
       padding: 30px; 
       border: 1px solid #bcbcbc; 
       background-color: #ffffff;
       border-radius: 8px;
       box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2); 
       color: black;
   }
   input[type="text"],
   input[type="password"] {
       width: 100%;
       padding: 12px; 
       margin: 12px 0; 
       box-sizing: border-box;
       border: 1px solid #d3d3d3; 
       border-radius: 5px; 
   }
   input[type="submit"] {
       width: 100%;
       background-color: #0d47a1; 
       color: white;
       padding: 16px 20px; 
       margin: 10px 0; 
       border: none;
       border-radius: 5px; 
       cursor: pointer;
   }
   input[type="submit"]:hover {
       background-color: #1565c0; 
   }
   .login-container {
       text-align: center;
   }
   .register-link {
       margin-top: 12px; 
   }
   .register-link a {
       text-decoration: none;
       color: #ff8f00; 
   }
   .register-link a:hover {
       text-decoration: underline;
       color: #ff6f00;
   }
   .error-message {
       color: #e53935; 
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

<div class="login-container">
    <h2>Login Form</h2>
    <form action="index.php" method="post">
        <input type="text" name="username" placeholder="Username" required autofocus><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <div class="register-link">
        <a href="register.php">Register</a>
    </div>
</div>
</body>
</html>