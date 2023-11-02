<?php
session_start();

// Check if the user is logged in 
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: Login.php");
    exit();
}

// Database connection
include('db_connect.php');

// Retrieve user's profile information based on the username
$username = $_SESSION['username'];
$sql = "SELECT * FROM followers WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="styles/index.css">

    <title>Chantelle's Portfolio</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?font-family=Inter:wght@400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .nav-links {
            font-size: 1rem;
            padding: 0 2.5rem;
            margin: 0;
            font-weight: 500;
            gap: 80px;
            align-items: flex-start;
            display: flex;
            margin-top: 18px;
            font-weight: 400;
        }

        a {
            color: white;
            text-decoration: none;
        }

        a:visited {
            color: white;
            text-decoration: none;
        }

        a:hover {
            color: red;
            opacity: 0.8;
        }

        .nav-links .icons {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .icons {
            padding-top: 18px;
        }

        .sm-icons {
            padding: 0 0.5rem;
            margin: 0;
            color: white;
        }

        .sm-icons:hover {
            opacity: 0.8;
        }

        .cvw-logo {
            width: 100px;
            height: 44.375px;
            margin-top: 12px;
        }

        .cvw-logo:hover {
            opacity: 0.7;
        }

        header {
            height: 100vh;
            position: relative;
            background: #211e26;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .card {
            align-items: center;
            display: flex;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            width: 60%;
        }

        .smile {
            height: 350px;
        }


        /*-------------PopUp-----------*/
        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        #popup h2 {
            text-align: center;
        }

        #dateDisplay {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }

        #popup button {
            display: block;
            margin: 0 auto;
            padding: 5px 10px;
            background-color: #0074d9;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #popup button:hover {
            background-color: #0056b3;
        }
    </style>

</head>

<body>
    <header>
        <nav class="container">
            <div class="logo-box">
                <img class="cvw-logo" src="http://localhost/lab4/Images/Cvw - Logo.png" alt="personal-logo">
            </div>

            <div class="nav-links">
                <a href="http://localhost/lab4/php/profile.php">Home</a>
                <a href="http://localhost/lab4/about.html">About Me</a>
                <a href="http://localhost/lab4/friends.html">Friends</a>
            </div>

            <div class="icons">
                <a href="https://www.instagram.com/i_am_chantey/" target="_blank" class="sm-icon"><ion-icon
                        name="logo-instagram"></ion-icon></a>
                <a href="https://www.linkedin.com/in/chantelle-c-van-wyk-7989bb33/" target="_blank"
                    class="sm-icon"><ion-icon name="logo-linkedin"></ion-icon></a>
                <a href="https://www.github.com/chrisane/" target="_blank" class="sm-icon"><ion-icon
                        name="logo-github"></ion-icon></a>
            </div>
        </nav>

        <div class="card" style="background-color: #2f2a36; border-radius: 18px;">
            <div class="card-body" style="display : flex; flex-direction : row;">
                <div class="card-img">
                    <img class="smile" src="http://localhost/lab4/Images/Smile-icon.png" alt="memoji-1">
                </div>

                <div class="card-text">
                    <h1 style="font-size: 52px; margin-top: 32px; line-height: 1.05; color: whitesmoke;">Hello <?php echo $name; ?></h1>
                    <p class="txt-crd" style="font-size: 18px; margin-top: 32px; margin-right: 20x; line-height: 1.05; color: whitesmoke;">
                        My name is Chantelle. Thank you for being here today! I hope you enjoy your browsing experience<br><br>Follow along to learn more about me!🫰🏽
                    </p><br>
                    <a class="btn btn-primary" href="#" role="button" id="calendarLink" style="width: 100px">Calender</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button id="logout" class="btn btn-primary" style="width: 100px">Sign Out</button>
                </div>
            </div>
        </div>

        <div class="header-txt" style="width: 50%; margin: 40px 290px;">
            <div id="popup">
                <h2>Today's Date</h2>
                <p id="dateDisplay"></p>
                <button onclick="closePopup()">Close</button>
            </div>
        </div>
    </header>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        // Function to display the popup and today's date
        function openPopup() {
            var popup = document.getElementById('popup');
            var dateDisplay = document.getElementById('dateDisplay');
            var today = new Date();
            var dateString = today.toDateString();
            dateDisplay.textContent = dateString;
            popup.style.display = 'block';
        }

        // Function to close the popup
        function closePopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'none';
        }

        // Add click event listener to the "Calendar" link
        var calendarLink = document.getElementById('calendarLink');
        calendarLink.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the link from navigating
            openPopup();
        });
        
        // Function to logout
        const logOutButton =document.getElementById("logout");
        logOutButton.addEventListener("click", () => {
            fetch("logout.php", {
                method: "GET",
            })
            .then((response) => {
                if (response.ok) {
                    // Redirect to login page
                    window.location.href = "login.php";
                }
            })
            .catch((error) => {
                console.error("Erron", error);
            });
        });
        
        </script>
</body>

</html>