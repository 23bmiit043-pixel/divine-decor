<?php
session_start();
include("connect.php");

if(isset($_POST['addproduct']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $subid = mysqli_real_escape_string($conn, $_POST['subid']);
    $offerid = mysqli_real_escape_string($conn, $_POST['offerid']);

    // Image handling with random prefix
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $random = rand(1000, 9999);
        $image = $random . "." . $_FILES['image']['name'];
        $tname = $_FILES['image']['tmp_name'];
        move_uploaded_file($tname, "gallery/" . $image);
    } else {
        $image = '';
    }

    // Get sub_category name from sub_category table
    $sub_query = "SELECT sub_category_name FROM sub_category WHERE sub_category_id = '$subid'";
    $sub_result = mysqli_query($conn, $sub_query);
    
    if($sub_row = mysqli_fetch_assoc($sub_result)) {
        $user_query = "INSERT INTO product(
            sub_category_id, 
            offer_id,
            p_name,
            quantity,
            p_price,
            p_description,
            p_image
        ) VALUES (
            '$subid',
            '$offerid',
            '$name',
            '$qty',
            '$price',
            '$desc',
            '$image'
        )";
        
        $user_query_run = mysqli_query($conn, $user_query);
        if ($user_query_run) {
            $_SESSION['status'] = "Product added successfully";
            header("Location: product.php");
            exit();
        } else {
            $_SESSION['status'] = "Error: " . mysqli_error($conn);
            header("Location: product.php");
            exit();
        }
    }
}

if(isset($_POST['updateproduct']))
{
    // Validate and get POST data with defaults
    $product_id = isset($_POST['product_id']) ? mysqli_real_escape_string($conn, $_POST['product_id']) : '';
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($conn, $_POST['price']) : '';
    $desc = isset($_POST['desc']) ? mysqli_real_escape_string($conn, $_POST['desc']) : '';
    $qty = isset($_POST['qty']) ? mysqli_real_escape_string($conn, $_POST['qty']) : '';
    $subid = isset($_POST['subid']) ? mysqli_real_escape_string($conn, $_POST['subid']) : '';
    $offerid = isset($_POST['offerid']) ? mysqli_real_escape_string($conn, $_POST['offerid']) : '';

    // Basic validation
    if(empty($product_id)) {
        $_SESSION['status'] = "Product ID is required";
        header('Location: product.php');
        exit();
    }

    $update_query = "UPDATE product SET 
        p_name='$name',
        p_price='$price',
        p_description='$desc',
        quantity='$qty',
        sub_category_id='$subid',
        offer_id='$offerid'
        WHERE pid='$product_id'";

    // Add random prefix for new image uploads
    if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
        $random = rand(1000, 9999);
        $image = $random . "." . $_FILES['img']['name'];
        $allowed_types = array('jpg','jpeg','png');
        $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        
        if(in_array($file_ext, $allowed_types)){
            move_uploaded_file($_FILES['img']['tmp_name'], 'gallery/'.$image);
            $update_query = "UPDATE product SET 
                p_name='$name',
                p_price='$price',
                p_description='$desc',
                quantity='$qty',
                p_image='$image',
                sub_category_id='$subid',
                offer_id='$offerid'
                WHERE pid='$product_id'";
        } else {
            $_SESSION['status'] = "Only JPG, JPEG and PNG files are allowed";
            header('Location: productedit.php?product_id='.$product_id);
            exit();
        }
    }

    $query_run = mysqli_query($conn, $update_query);

    if($query_run)
    {
        $_SESSION['status'] = "Product Updated Successfully";
        header('Location: product.php');
        exit();
    }
    else
    {
        $_SESSION['status'] = "Product Update Failed: " . mysqli_error($conn);
        header('Location: productedit.php?product_id='.$product_id);
        exit();
    }
}

if(isset($_POST['DeleteUserBtn']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // First delete related records from order table
        $query1 = "DELETE FROM payment WHERE order_id IN (SELECT order_id FROM `order` WHERE pid='$user_id')";
        mysqli_query($conn, $query1);
        
        $query2 = "DELETE FROM `order` WHERE pid='$user_id'";
        mysqli_query($conn, $query2);

        // Delete from feedback table
        $query3 = "DELETE FROM feedback WHERE pid='$user_id'";
        mysqli_query($conn, $query3);

        // Delete from gallery table
        $query4 = "DELETE FROM gallery WHERE pid='$user_id'";
        mysqli_query($conn, $query4);

        // Finally delete the product
        $query5 = "DELETE FROM product WHERE pid='$user_id'";
        mysqli_query($conn, $query5);

        // If everything is successful, commit the transaction
        mysqli_commit($conn);
        $_SESSION['status'] = "Product deleted successfully";
        header("Location: product.php");
        exit();
    } catch (Exception $e) {
        // An error occurred, rollback changes
        mysqli_rollback($conn);
        $_SESSION['status'] = "Product deletion failed: " . $e->getMessage();
        header("Location: product.php");
        exit();
    }
}
?>
