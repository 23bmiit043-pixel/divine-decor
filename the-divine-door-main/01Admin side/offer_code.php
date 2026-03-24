<?php
session_start();
include("connect.php");

if(isset($_POST['addoffer'])) {
    $coupon_code = mysqli_real_escape_string($conn, $_POST['coupon_code']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $discount_amt = mysqli_real_escape_string($conn, $_POST['discount_amt']);
    $offer_desc = mysqli_real_escape_string($conn, $_POST['offer_description']);
    $min_amt = mysqli_real_escape_string($conn, $_POST['min_amt']);

    $user_query = "INSERT INTO offer(coupone_code, start_date, end_date, discount_amt, Offer_discription, min_ant) 
                  VALUES('$coupon_code', '$start_date', '$end_date', '$discount_amt', '$offer_desc', '$min_amt')";
    $user_query_run = mysqli_query($conn, $user_query);
    if($user_query_run) {
        $_SESSION['status'] = "Offer added successfully";
        header("Location: productoffer.php");
        exit();
    } else {
        $_SESSION['status'] = "Error adding offer: " . mysqli_error($conn);
        header("Location: productoffer.php");
        exit();
    }
}

if(isset($_POST['updateoffer'])) {
    $offer_id = $_POST['offer_id'];
    $start_date = $_POST['offer_startdate'];
    $end_date = $_POST['offer_enddate']; 
    $discount_amt = $_POST['offer_amt'];
    $offer_desc = $_POST['offer_desc'];

    $query = "UPDATE offer SET start_date='$start_date', end_date='$end_date', 
             discount_amt='$discount_amt', Offer_discription='$offer_desc' 
             WHERE offer_id='$offer_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['status'] = "Offer updated successfully";
        header("Location: productoffer.php");
    } else {
        $_SESSION['status'] = "Offer updating Failed";
    }
}

if(isset($_POST['DeleteUserBtn'])) {
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM gallery WHERE gallery_id='$user_id'";
    $query_run = mysqli_query($conn, $query);
    if($query_run) {
        $_SESSION['status'] = "Offer deleted successfully";
        header("Location: offer.php");
    } else {
        $_SESSION['status'] = "Offer deleting Failed";
    }
}

if(isset($_POST['update_offer'])) {
    $offer_id = mysqli_real_escape_string($conn, $_POST['offer_id']);
    $coupon_code = mysqli_real_escape_string($conn, $_POST['coupone_code']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $discount_amt = mysqli_real_escape_string($conn, $_POST['discount_amt']);
    $description = mysqli_real_escape_string($conn, $_POST['Offer_discription']);
    $min_amt = mysqli_real_escape_string($conn, $_POST['min_ant']);

    $query = "UPDATE offer SET 
        coupone_code='$coupon_code',
        start_date='$start_date',
        end_date='$end_date',
        discount_amt='$discount_amt',
        Offer_discription='$description',
        min_ant='$min_amt'
        WHERE offer_id='$offer_id'";
    
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['status'] = "Offer Updated Successfully";
        header('Location: productoffer.php');
        exit();
    } else {
        $_SESSION['status'] = "Offer Update Failed";
        header('Location: offeredit.php?offer_id='.$offer_id);
        exit();
    }
}
?>