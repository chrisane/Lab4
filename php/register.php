<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="/styles/phpstyle.css">

    <style>
        /* Center the alert in the middle of the screen */
        .center-alert {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>

    <title>Registration</title>
</head>

<body style="background: #211e26;">
    <div class="content-card" style="align-items: center; display: flex; justify-content:center; margin-top: 70px">
        <div class="card" style="background-color: white; border-radius: 12px; padding: 35px; width: 25%;">
            <small><a href="http://localhost/lab4/Index.html"><ion-icon name="arrow-back-outline" style="font-size: 10px;"></ion-icon>  Back to Home</a></small>
            <h1>Sign Up</h1><br>
            <form method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div><br>
                <button type="submit" class="btn btn-primary" style="width: 100px">Register</button><br><br>
                <small>Already have an account? <a href="http://localhost/lab4/php/login.php">Login</a></small>
            </form>
        </div>
    </div>

    <?php
    // Include your database connection code here
    include('db_connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        // One-way password, make it secure
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO followers (name, email, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error: " . $conn->error); // Add error handling
        }

        $stmt->bind_param("ssss", $name, $email, $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');</script>"; // Display a JavaScript alert
        } else {
            echo "<script>alert('Registration failed. Error: " . $stmt->error . "');</script>"; // Display a JavaScript alert
        }
    }
    $conn->close();
    ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 

</body>
</html>