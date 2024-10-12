<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maestro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_successful = false; 
$message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = '$input_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $input_password) {
            $login_successful = true; 
            header("Location: manage.php"); 
            exit(); 
        } else {
            $message = "<p style='color: red; font-weight: bold; text-align: center; margin: 20px;'>Password is not correct</p>";
        }
    } else {
        $message = "<p style='color: red; font-weight: bold; text-align: center; margin: 20px;'>Username does not exist</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif; 
            background-color: white;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            font-size: 30px; 
            color: #1F1F1F; /*4th*/
            text-align: center;
            margin-bottom: 25px; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        }

        .container {
            width: 100%;
            max-width: 500px; 
            background-color: #F5F5F5; /*1st*/
            border: 2px solid black;
            border-radius: 10px;
            padding: 35px; 
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2); 
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid black;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #1F1F1F; /*4th*/
            color:  #F5F5F5; /*1st*/
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: black;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 10px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($login_successful) {
            echo "<h2 class='success-message'>Access granted!!!</h2>";
        } else {
            echo "<h2>Login</h2>";
            echo '<form method="POST">';
            echo 'Username: <input type="text" name="username" required><br><br>';
            echo 'Password: <input type="password" name="password" required><br><br>';
            echo '<input type="submit" value="Login">';
            echo '</form>';
            echo $message; 
        }
        ?>
    </div>
</body>
</html>
