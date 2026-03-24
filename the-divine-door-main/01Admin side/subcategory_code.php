<?php
session_start();
include("connect.php");

if(isset($_POST['addsubcategory']))
{
    $category_id = $_POST['category_id'];
    $sub_category_name = $_POST['sub_category_name'];
  
    $user_query = "INSERT INTO sub_category(category_id, sub_category_name) VALUES('$category_id','$sub_category_name')";
    $user_query_run = mysqli_query($conn, $user_query);
    if($user_query_run)
    {
        $_SESSION['status'] = "Sub-category added successfully";
        header("Location: subcategory.php");
    }
    else
    {
        $_SESSION['status'] = "Sub-category added Failed";
        header("Location: subcategory.php");
    }
}

if(isset($_POST['updatesubcategory']))
{
    $sub_category_id = $_POST['sub_category_id'];
    $category_id = $_POST['category_id'];
    $sub_category_name = $_POST['sub_category_name'];
    
    $query = "UPDATE sub_category SET category_id = '$category_id', sub_category_name = '$sub_category_name' WHERE sub_category_id = '$sub_category_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Category updated successfully";
        header("Location: subcategory.php");
    }
    else
    {
        $_SESSION['status'] = "Category updating Failed";
        header("Location: subcategory.php");
    }
}

if(isset($_POST['DeleteUserBtn']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // First check if subcategory has any products
        $check_query = "SELECT * FROM product WHERE sub_category_id='$user_id'";
        $check_result = mysqli_query($conn, $check_query);
        
        if(mysqli_num_rows($check_result) > 0) {
            throw new Exception("Cannot delete sub-category - It has existing products");
        }

        // If no products exist, delete the subcategory
        $query = "DELETE FROM sub_category WHERE sub_category_id='$user_id'";
        $query_run = mysqli_query($conn, $query);

        if(!$query_run) {
            throw new Exception("Failed to delete sub-category: " . mysqli_error($conn));
        }

        // If everything is successful, commit the transaction
        mysqli_commit($conn);
        $_SESSION['status'] = "Sub-category deleted successfully";
        header("Location: subcategory.php");
        exit();
    } catch (Exception $e) {
        // An error occurred, rollback changes
        mysqli_rollback($conn);
        $_SESSION['status'] = $e->getMessage();
        header("Location: subcategory.php");
        exit();
    }
}
?>