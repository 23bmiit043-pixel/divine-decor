<?php
session_start();
if(isset($_SESSION['auth']))
{
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    unset($_SESSION['delivery_id']);
    $_SESSION['message'] = "Logged out successfully";
}
header('Location: login.php');
exit();
?>
