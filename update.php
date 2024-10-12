<?php
session_start();

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "maestro"); 
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Initialize message variable
$message = ""; 
$messageClass = ""; 

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // New field for ID
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user ID exists in the database
    $checkSql = "SELECT * FROM login WHERE id = '$id'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // User ID exists, proceed with the update
        $updateSql = "UPDATE login SET username='$username', password='$password' WHERE id='$id'";
        if ($conn->query($updateSql) === TRUE) {
            // Set session variables for success message
            $_SESSION['message'] = "User updated successfully!";
            $_SESSION['messageClass'] = "success"; 
            // Redirect to manage.php
            header("Location: manage.php");
            exit();
        } else {
            $message = "Error updating record: " . $conn->error;
            $messageClass = "error"; 
        }
    } else {
        // User ID does not exist, show invalid input alert
        $message = "User ID does not exist!";
        $messageClass = "error"; 
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: white;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            flex-direction: column;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            background-color: #F5F5F5; /*1st*/
            border: 2px solid black;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
        }

        .alert {
            width: 100%;
            max-width: 500px;
            padding: 15px;
            color: white;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            font-size: 15px;
            font-weight: bold;
        }

        .alert.success {
            background-color: #4CAF50; /* green */
        }

        .alert.error {
            background-color: #f44336; /* red */
        }

        h2 {
            text-align: center;
            font-size: 30px;
            color: #1F1F1F; /*4th*/
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: black;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid black;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"], .back-button {
            width: 100%;
            padding: 10px;
            background-color: #1F1F1F; /*4th*/
            color:  #F5F5F5; /*1st*/
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px; 
        }

        input[type="submit"]:hover, .back-button:hover {
            background-color: black;
        }
    </style>
    <script>
        function hideAlert() {
            const alertBox = document.querySelector('.alert');
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.display = 'none';
                }, 2000); // 2000ms = 2 seconds
            }
        }

        window.onload = hideAlert;
    </script>
    <title>Update User Record</title>
</head>
<body>
    <?php if ($message): ?>
        <div class="alert <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Update User Record</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id ?? ''); ?>"> 

            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="id" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Update">
            <button type="button" class="back-button" onclick="window.location.href='manage.php'">Back</button>
        </form>
        </div>
</body>
</html>
