<?php
session_start();
include("connect.php");

if(isset($_POST['addDelivery']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Handle ID Proof upload
    $idproof = $_FILES['idproof']['name'];
    $idproof_new = rand(1000, 10000) . "-" . $idproof;
    move_uploaded_file($_FILES['idproof']['tmp_name'], "Images/deliveryperson/" . $idproof_new);

    // Handle Profile Image upload
    $profileimg = $_FILES['profileimg']['name'];
    $profileimg_new = rand(1000, 10000) . "-" . $profileimg;
    move_uploaded_file($_FILES['profileimg']['tmp_name'], "Images/deliveryperson/" . $profileimg_new);

    $query = "INSERT INTO delivery_person (Name, password, Contact_no, Email, `Id-proof`, Photo) 
              VALUES ('$name', '$password', '$contact', '$email', '$idproof_new', '$profileimg_new')";
    
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Delivery Person Added Successfully";
        header("Location: deliveryperson.php");
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Delivery Person Addition Failed";
        header("Location: deliveryperson.php");
        exit(0);
    }
}

if(isset($_POST['updatedelivery']))
{
    $delivery_id = mysqli_real_escape_string($conn, $_POST['delivery_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "UPDATE delivery_person SET 
            Name='$name',
            password='$password',
            Contact_no='$contact',
            Email='$email'
            WHERE delivery_person_id='$delivery_id'";

    // Handle ID Proof update
    if(isset($_FILES['idproof']) && $_FILES['idproof']['name'] != ""){
        $old_image_query = "SELECT `Id-proof` FROM delivery_person WHERE delivery_person_id='$delivery_id'";
        $old_image_result = mysqli_query($conn, $old_image_query);
        $old_image_row = mysqli_fetch_assoc($old_image_result);
        
        @unlink("Images/deliveryperson/".$old_image_row['Id-proof']);
        
        $idproof = $_FILES['idproof']['name'];
        $idproof_new = rand(1000, 10000) . "-" . $idproof;
        move_uploaded_file($_FILES['idproof']['tmp_name'], "Images/deliveryperson/" . $idproof_new);
        
        $query = "UPDATE delivery_person SET 
                Name='$name',
                password='$password',
                Contact_no='$contact',
                Email='$email',
                `Id-proof`='$idproof_new'
                WHERE delivery_person_id='$delivery_id'";
    }

    // Handle Profile Image update
    if(isset($_FILES['profileimg']) && $_FILES['profileimg']['name'] != ""){
        $old_image_query = "SELECT Photo FROM delivery_person WHERE delivery_person_id='$delivery_id'";
        $old_image_result = mysqli_query($conn, $old_image_query);
        $old_image_row = mysqli_fetch_assoc($old_image_result);
        
        @unlink("Images/deliveryperson/".$old_image_row['Photo']);
        
        $profileimg = $_FILES['profileimg']['name'];
        $profileimg_new = rand(1000, 10000) . "-" . $profileimg;
        move_uploaded_file($_FILES['profileimg']['tmp_name'], "Images/deliveryperson/" . $profileimg_new);
        
        $query = "UPDATE delivery_person SET 
                Name='$name',
                password='$password',
                Contact_no='$contact',
                Email='$email',
                Photo='$profileimg_new'
                WHERE delivery_person_id='$delivery_id'";
    }

    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Delivery Person updated successfully";
        header("Location: deliveryperson.php");
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Delivery Person updating Failed";
        header("Location: deliverypersonedit.php?delivery_person_id=".$delivery_id);
        exit(0);
    }
}

if(isset($_POST['DeleteUserBtn']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    
    // Get image paths before deleting
    $query = "SELECT `Id-proof`, Photo FROM delivery_person WHERE delivery_person_id='$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    
    // First, update related orders to remove the delivery person reference
    $update_orders = "UPDATE order_details SET delivery_person_id = NULL WHERE delivery_person_id='$user_id'";
    $update_run = mysqli_query($conn, $update_orders);
    
    // Then proceed with delivery person deletion
    if($row){
        @unlink("Images/deliveryperson/".$row['Id-proof']);
        @unlink("Images/deliveryperson/".$row['Photo']);
    }

    $query = "DELETE FROM delivery_person WHERE delivery_person_id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Delivery Person deleted successfully";
        header("Location: deliveryperson.php");
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Delivery Person deletion Failed";
        header("Location: deliveryperson.php");
        exit(0);
    }
}
?>
