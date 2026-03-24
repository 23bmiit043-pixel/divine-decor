<?php
session_start();
include('connect.php');

if(isset($_POST['adduser']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $cellno = mysqli_real_escape_string($conn, $_POST['cellno']);

    $query = "INSERT INTO admin (Email, Password, FirstName, LastName, Gender, Address, State, Cellno) 
              VALUES ('$email', '$password', '$firstname', '$lastname', '$gender', '$address', '$state', '$cellno')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Admin Added Successfully";
        header("Location: admin.php");
    }
    else
    {
        $_SESSION['status'] = "Admin Not Added: " . mysqli_error($conn);
        header("Location: admin.php");
    }
}

if(isset($_POST['DeleteUserBtn']))
{
    $userid = mysqli_real_escape_string($conn, $_POST['delete_id']);
    
    $query = "DELETE FROM admin WHERE aid='$userid' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Admin Deleted Successfully";
        header("Location: admin.php");
    }
    else
    {
        $_SESSION['status'] = "Admin Not Deleted";
        header("Location: admin.php");
    }
}

if(isset($_POST['updateadmin'])) {
    $admin_id = $_POST['admin_id'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $cellno = $_POST['cellno'];

    // Handle image upload
    $old_image = $_POST['old_image'];
    $new_image = $_FILES['adminProfile']['name'];
    $admin_image = $old_image; // Default to old image

    if($new_image != "") {
        $image_extension = pathinfo($new_image, PATHINFO_EXTENSION);
        $allowed_extensions =  array('jpg', 'jpeg', 'png', 'gif');
        
        if(in_array(strtolower($image_extension), $allowed_extensions)) {
            $filename = time() . '.' . $image_extension;
            $admin_image = $filename;
            move_uploaded_file($_FILES['adminProfile']['tmp_name'], 'images/admin/'.$filename);
            // Delete old image if it exists
            if($old_image != "" && file_exists('images/admin/'.$old_image)) {
                unlink('images/admin/'.$old_image);
            }
        }
    }

    // Handle password update
    $password_update = "";
    if(isset($_POST['change_password']) && $_POST['change_password'] == 'on') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Verify current password
        $check_password = "SELECT Password FROM admin WHERE aid='$admin_id'";
        $check_result = mysqli_query($conn, $check_password);
        $row = mysqli_fetch_assoc($check_result);

        if($row['Password'] == $current_password) {
            if($new_password == $confirm_password) {
                $password_update = ", Password='$new_password'";
            } else {
                $_SESSION['status'] = "New passwords do not match!";
                header('Location: adminedit.php?aid='.$admin_id);
                exit();
            }
        } else {
            $_SESSION['status'] = "Current password is incorrect!";
            header('Location: adminedit.php?aid='.$admin_id);
            exit();
        }
    }

    // Update query
    $query = "UPDATE admin SET 
              Email='$email',
              FirstName='$firstname',
              LastName='$lastname',
              Gender='$gender',
              Address='$address',
              State='$state',
              Cellno='$cellno',
              adminProfile='$admin_image'
              $password_update
              WHERE aid='$admin_id'";

    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['status'] = "Admin Updated Successfully";
        header('Location: admin.php');
    } else {
        $_SESSION['status'] = "Admin Update Failed: " . mysqli_error($conn);
        header('Location: adminedit.php?aid='.$admin_id);
    }
}
?>
