<?php

session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');
?>
<div class="content-wrapper">
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Delivery Person</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Edit Delivery Person</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php
  if(isset($_SESSION['status']))
  {
    echo"<h4>".$_SESSION['status']."</h4>";
    unset($_SESSION['status']);
  }

?>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12"></div>

    
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Delivery Person
                </h3>
                <a href="deliveryperson.php"   class="btn btn-danger float-right" >Back</a>
              </div>
              <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                    <form action="delivery_code.php" method="POST" enctype="multipart/form-data">
                    
      <div class="modal-body">
        <?php
        if(isset($_GET['delivery_person_id']))
        {
            $delivery_id=$_GET['delivery_person_id'];
            $query="SELECT * FROM delivery_person WHERE delivery_person_id='$delivery_id' LIMIT 1";
            $query_run=mysqli_query($conn,$query);
            if(mysqli_num_rows($query_run)>0)
            {
                foreach($query_run as $row)
                {
                        
                    ?>
<input type="hidden" name="delivery_id" value="<?php echo $row['delivery_person_id'] ?>">
<div class="form-group">

                      
                     <div class="form-group">
                 <label for="Name">Name</label>
                    <input type="text" name="name" value="<?php echo $row['Name'] ?>" class="form-control" placeholder="Name">
                     </div>
                     <div class="form-group">
                 <label for="password">Password</label>
                    <input type="text" name="password" value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>" class="form-control" placeholder="Password">
                     </div>
                     <div class="form-group">
                 <label for="contact">Contact</label>
                    <input type="text" name="contact" value="<?php echo $row['Contact_no'] ?>" class="form-control" placeholder="Contact">
                     </div>
                     <div class="form-group">
                 <label for="email">Email</label>
                    <input type="text" name="email" value="<?php echo $row['Email'] ?>" class="form-control" placeholder="Email">
                     </div>
                     <div class="form-group">
                 <label for="idproof">Id-Proof</label>
                 <input type="file" name="idproof" class="form-control" accept="image/*">
                 <?php if($row['Id-proof']): ?>
                     <img src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/Images/deliveryperson/<?php echo $row['Id-proof']; ?>" width="100px" height="100px" alt="Current ID Proof">
                 <?php endif; ?>
                     </div>
                     <div class="form-group">
                 <label for="profileimg">Profile Image</label>
                 <input type="file" name="profileimg" class="form-control" accept="image/*">
                 <?php if($row['Photo']): ?>
                     <img src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/Images/deliveryperson/<?php echo $row['Photo']; ?>" width="100px" height="100px" alt="Current Profile Photo">
                 <?php endif; ?>
                     </div>
                    <?php
                }
            }
            else
            {
                echo "<h4>No Record Found.</h4>";
            }
        }
       
        ?>
      </div>
      <div class="modal-footer">
        
        <button type="submit" name="updatedelivery" class="btn btn-info">Update</button>
      </div>
      
      </form>
      
                    </div>
                </div>
                </div>
                </div>
                </div>

</div>
</section>
</div>
<?php include('script.php');?>

<?php
include('includes/footer.php');
?>