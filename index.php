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
  <!-- Include SweetAlert CSS and JS from CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>

</head>


<body>
  <div class="container">
    <div class="myform">
      <h1>Login</h1>
      <br><br>
      <?php
      session_start();

      if (isset($_SESSION['login_error'])) {
        echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';

        // Display the countdown timer if applicable
        if (isset($_SESSION['ban_timestamp'])) {
          $remainingTime = max(0, 120 - (time() - $_SESSION['ban_timestamp']));
          echo '<p id="countdown" style="color: red;">Please try again in ' . $remainingTime . ' seconds.</p>';

          // Display the live countdown using JavaScript
          echo '<script>
                var countdown = ' . $remainingTime . ';
                function updateCountdown() {
                    document.getElementById("countdown").innerText = "Please try again in " + countdown + " seconds.";
                    countdown--;
    
                    if (countdown < 0) {
                        clearInterval(timer);
                        document.getElementById("countdown").style.display = "none";
                    }
                }
    
                var timer = setInterval(updateCountdown, 1000);
            </script>';
        }

        unset($_SESSION['login_error']);
      }

      ?>
      <form action="action/login_process.php" method="POST">
        <input type="text" id="username" name="username" placeholder="Username" required><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="submit">LOGIN</button>
      </form>
    </div>
    <div class="image">
      <img src="./assets\images\buluaLogo.png">
    </div>
  </div>
</body>

</html>