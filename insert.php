<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maestro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$record_created = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    $check_user_sql = "SELECT * FROM login WHERE username = '$new_username'";
    $check_user_result = $conn->query($check_user_sql);

    if ($check_user_result->num_rows > 0) {
        echo "<p style='color: red; text-align: center;'>Username already exists, please choose a different one.</p>";
    } else {
        $sql = "INSERT INTO login (username, password) VALUES ('$new_username', '$new_password')";
        if ($conn->query($sql) === TRUE) {
            $record_created = true; 
            header("Location: manage.php");
            exit(); 
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Record</title>
    <style>
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
            color: #1F1F1F; /*4th*/
            text-align: center;
            font-size: 30px;
            margin-bottom: 25px; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        }
         
        .container {
            background-color: #F5F5F5; /*1st*/
            border: 2px solid black;
            border-radius: 10px;
            padding: 20px;
            width: 400px;
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
            color: #F5F5F5; /*1st*/
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: black;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($record_created): ?>
            <h2 style="color: green; text-align: center;">New record created successfully!</h2>
        <?php else: ?>
            <h2>Add New Record</h2>
            <form method="POST">
                Username: <input type="text" name="username" required><br><br>
                Password: <input type="password" name="password" required><br><br>
                <input type="submit" value="Add">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
