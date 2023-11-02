<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login</title>
</head>

<body style="background: #211e26;">
    <div class="content-card" style="align-items: center; display: flex; justify-content:center; margin-top: 70px">
        <div class="card" style="background-color: white; border-radius: 12px; padding: 35px; width: 25%;">
            <form  method="post">
                <small><a href="http://localhost/lab4/Index.html"><ion-icon name="arrow-back-outline" style="font-size: 10px;"></ion-icon>  Back to Home</a></small>
                <br><h1>Sign In</h1><br>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div><br>
                <button type="submit" class="btn btn-primary" style="width:100px">Login</button><br><br>
                <small>Don't have an account? <a href="http://localhost/lab4/php/register.php">Register</a></small>
            </form>
        </div>
    </div>

    <?php
    session_start();
    include('db_connect.php');  // Include your database connection code here

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM followers WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Successful login
                session_start();
                $_SESSION['username'] = $username;
                header("Location: profile.php"); // Redirect to the profile page
                exit();
            } else {
                echo "<script>alert('Invalid password. Please try again.');</script>"; // Display a JavaScript alert
            }
        } else {
            echo "<script>alert('Invalid username. Please try again.');</script>"; // Display a JavaScript alert
        }
    }

    $conn->close();
    ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
</body>
</html>
