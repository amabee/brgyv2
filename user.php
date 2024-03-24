<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
        integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <style>
        body {
            background: url('assets/images/loginbg.png') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            margin-top: 40px;
            /* Adjust as needed */
        }

        /* New style for register button */
        .register-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            /* You can choose your preferred color */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .register-btn:hover {
            background-color: #2980b9;
            /* Change the color on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="myform">
            <h1>Login</h1>
            <br><br>

            <form action="user/login_prog.php" method="POST">
                <label for="">Serial Number</label>
                <input type="text" id="username" name="username" placeholder="Enter Serial Number" required><br>
                <label for="">MM/DD/YY</label>
                <input type="date">
                <button type="submit" name="submit">LOGIN</button>
                <a href="register.php" class="register-btn">Register</a>
            </form>
        </div>
        <div class="image">
            <img src="./assets\images\h.png">
        </div>
    </div>


</body>

</html>