<?php
session_start();
include("connect.php");


if(isset($_POST['addimage']))
{
    
    $image1=$_POST['image1'];
    $image2=$_POST['image2'];
    $image3=$_POST['image3'];

    $user_query="insert into gallery(image1_path,image2_path,image3_path) VALUES($image1,$image2,$image3)";
    $user_query_run=mysqli_query($conn,$user_query);
    if($user_query_run)
    {
            $_SESSION['status']="Images added successfully";
             header( "Location: gallery.php");
    }


}
if(isset($_POST['updateimage']))
{
    $gallery_id=$_POST['gallery_id'];
    $image1=$_POST['image1'];
    $image2=$_POST['image2'];
    $image3=$_POST['image3'];
    $query="UPDATE gallery SET image1_path='$imgae1',image2_path='$image2',image3_path='$image3' WHERE gallery_id='$gallery_id'";
    $query_run=mysqli_query($conn,$query);

    if($query_run)
    {
            $_SESSION['status']="Images updated successfully";
             header( "Location: galleryedit.php");
    }
    else
    {
        $_SESSION['status']="Images updating Failed";
    }
}
if(isset($_POST['DeleteUserBtn']))
{
    $user_id=$_POST['delete_id'];

    $query="DELETE FROM gallery WHERE gallery_id='$user_id'";
    $query_run=mysqli_query($conn,$query);
    if($query_run)
    {
            $_SESSION['status']="Images deleted successfully";
             header( "Location: gallery.php");
    }
    else
    {
        $_SESSION['status']="Images deleting Failed";
    }

}
?>