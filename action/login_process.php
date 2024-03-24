<?php
session_start();
include_once('../config.php');

define('ADMIN_DASHBOARD', '../admin/dashboard/dashboard.php');
define('SUPERADMIN_DASHBOARD', '../superadmin/dashboard/dashboard.php');
define('NURSE_DASHBOARD', '../nurse/dashboard/dashboard.php');
define('MIDWIFE_DASHBOARD', '../midwife/dashboard/dashboard.php');
define('STAFF_DASHBOARD', '../staff/dashboard/dashboard.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id, role, password, is_deleted FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        $is_deleted = $row["is_deleted"];

        // Check if the account is already marked as deleted
        if ($is_deleted == 1) {
            echo "This account has been deactivated. Please contact support.";
            exit;
        }

        // Check if the user is banned
        if (isset($_SESSION['ban_timestamp']) && (time() - $_SESSION['ban_timestamp']) < 120) {
            $_SESSION['login_error'] = "Too many login attempts. This account has been temporarily banned. Please try again later.";
            header("Location: ../index.php");
            exit;
        }

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            // Successful login, reset login attempts and ban timestamp
            // Assuming you have a database connection named $conn

            if (password_verify($password, $hashed_password)) {
                // Successful login, reset login attempts and ban timestamp
                unset($_SESSION['login_attempts']);
                unset($_SESSION['ban_timestamp']);

                // Save login information to the logs table
                $user_id = $row["id"];
                date_default_timezone_set('Asia/Manila');
                $login_time = date("Y-m-d h:i:s a");

                $login_date = date("Y-m-d");
                $login_type = "login";

                $sql = "INSERT INTO logs (user_id, time, date, type) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("isss", $user_id, $login_time, $login_date, $login_type);

                    if ($stmt->execute()) {
                        // Successful insertion
                        echo 'Success';

                        // Set session variables
                        $_SESSION["username"] = $username;
                        $_SESSION["role"] = $row["role"];
                        $_SESSION["user_id"] = $user_id;
                        switch ($_SESSION["role"]) {
                            case "admin":
                                header("Location: " . ADMIN_DASHBOARD);
                                exit;
                            case "superadmin":
                                header("Location: " . SUPERADMIN_DASHBOARD);
                                exit;
                            case "nurse":
                                header("Location: " . NURSE_DASHBOARD);
                                exit;
                            case "midwife":
                                header("Location: " . MIDWIFE_DASHBOARD);
                                exit;
                            case "staff":
                                header("Location: " . STAFF_DASHBOARD);
                                exit;
                            default:
                                echo "Invalid role!";
                                exit;
                        }
                    } else {
                        // Error handling for execute
                        echo 'Error: ' . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    // Error handling for prepare
                    echo 'Error preparing statement: ' . $conn->error;
                }
            }


        } else {
            // Failed login attempt
            if (!isset($_SESSION['login_attempts'])) {
                // Initialize the session for login attempts
                $_SESSION['login_attempts'] = array(
                    'count' => 1
                );
            } else {
                // Increment the login attempts counter
                $_SESSION['login_attempts']['count']++;
            }

            // Check if the number of attempts exceeds 3
            if ($_SESSION['login_attempts']['count'] > 3) {
                // Set the ban timestamp in the session
                $_SESSION['ban_timestamp'] = time();
                $_SESSION['login_error'] = "Too many login attempts. This account has been temporarily banned. Please try again later.";
                header("Location: ../index.php");
                exit;
            }
        }
    }

    // Authentication failed
    header("Location: ../index.php?error=Invalid username or password");
    exit;
}

$conn->close();
?>