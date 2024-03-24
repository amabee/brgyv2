<?php
session_start();

if (isset($_SESSION["username"]) && isset($_SESSION["role"])) {
   
}else{
    header("Location: ../../index.php");
exit;
}

// http://localhost/brgyv2/superadmin/superadmin/dashboard/dashboard.php
//http://localhost/brgyv2/superadmin/dashboard/dashboard.php
//http://localhost/brgyv2/superadmin/dashboard/dashboard.php

?>