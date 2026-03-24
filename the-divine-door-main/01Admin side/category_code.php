<?php
session_start();
include("connect.php");


if(isset($_POST['addcategory']))
{
    $name=$_POST['name'];
  

    $user_query="insert into category(category_name) VALUES('$name')";
    $user_query_run=mysqli_query($conn,$user_query);
    if($user_query_run)
    {
            $_SESSION['status']="Category added successfully";
             header( "Location: category.php");
    }
    else
    {
        $_SESSION['status']="Category added Failed";
    }


}
if(isset($_POST['updatecategory']))
{
    $category_id=$_POST['category_id'];
    $name=$_POST['name'];
    $query="UPDATE category SET category_name='$name' WHERE category_id='$category_id'";
    $query_run=mysqli_query($conn,$query);

    if($query_run)
    {
            $_SESSION['status']="Category updated successfully";
             header( "Location: categoryedit.php");
    }
    else
    {
        $_SESSION['status']="Category updating Failed";
    }
}
if(isset($_POST['DeleteUserBtn']))
{
    $user_id=$_POST['delete_id'];

    $query="DELETE FROM category WHERE category_id='$user_id'";
    $query_run=mysqli_query($conn,$query);
    if($query_run)
    {
            $_SESSION['status']="Category deleted successfully";
             header( "Location: category.php");
    }
    else
    {
        $_SESSION['status']="Category deleting Failed";
    }

}
?>
?>