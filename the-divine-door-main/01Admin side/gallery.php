<?php
session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');
?>

<div class="content-wrapper">

<!--Add Modal-->
<div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Image</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="gallery_code.php" method="POST">
      <div class="modal-body">
        
        <div class="form-group">
            <label for="image">Image-1</label>
            <input type="file" name="image1" class="form-control" accept=".jpg, .png" required placeholder="Image1">
        </div>
        <div class="form-group">
            <label for="image">Image-2</label>
            <input type="file" name="image2" class="form-control" accept=".jpg, .png" required placeholder="Image2">
        </div>
        <div class="form-group">
            <label for="image">Image-3</label>
            <input type="file" name="image3" class="form-control" accept=".jpg, .png" required placeholder="Image3">
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addimage" class="btn btn-primary">Save changes</button>
      </div>
      
      </form>
    </div>
  </div>
</div>
<!--Delete Modal-->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Image</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="gallery_code.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="delete_id" class="delete_user_id">
        <p>
          Are you Sure You want to delete.
        </p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="DeleteUserBtn" class="btn btn-primary">Yes, Delete</button>
      </div>
      </form>
      </div>
      </div>
      </div>
<!--Delete Modal-->


<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Gallery</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Gallery</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12"></div>
<?php
  if(isset($_SESSION['status']))
  {
    echo"<h4>".$_SESSION['status']."</h4>";
    unset($_SESSION['status']);
  }

?>
    
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Gallery
                </h3>
                <a href="#"  data-bs-toggle="modal" data-bs-target="#AddUserModal" class="btn btn-primary float-right" >Add Image</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Galley_id</th>
                    <th>Product_id</th>
                    <th>Image1_path</th>
                    <th>Image2_path</th>
                    <th>image3_path</th>
                    <th>Options</th>
      
                  </tr>
                  </thead>
                  <tbody>
              <?php
                      $query="Select * from gallery";
                      $query_run=mysqli_query($conn,$query);

                      if(mysqli_num_rows($query_run) >0)
                      {
                          foreach($query_run as $row)
                          {
                            
                            ?>
                             <tr>
                                        <td><?php echo $row['gallery_id']; ?></td>
                                        <td><?php echo $row['product_id']; ?></td>
                                        <td><img src="<?php echo $row['image1_oath'];?>" height="50" width="50" alt="IMAGE"></td>
                                        <td><img src="<?php echo $row['iamge2_path'];?>" height="50" width="50" alt="IMAGE"></td>
                                        <td><img src="<?php echo $row['image3_path'];?>" height="50" width="50" alt="IMAGE"></td>

                                        <t  d>
                                            <a href="Galleryedit.php?gallery_id=<?php echo $row['gallery_id']; ?>" class="btn btn-info md-sm">Edit</a>
                                            <button type="button" value="<?php echo $row['gallery_id']; ?>" class="btn btn-danger md-sm deletebtn">Delete</button>
                                        </td>

                                      </tr>
                            <?php
                          }
                      }
                      else
                      {
                        ?>
                        <tr>
                          <td>No Record Found</td>
                          </tr>
                          <?php
                      }
                    ?>
                   </tbody>
                   </table>
                   </div>
                   </div>
                   </div>
                   </div>
                   </section>
                   </div>
                  </div>
<?php include('script.php');?>
<script>
$(document).ready(function () {
  $('.deletebtn').click(function (e) { 
    e.preventDefault();
    
    var user_id=$(this).val();
    //console.log(user_id);
    $('.delete_user_id').val(user_id);
    $('#DeleteModal').modal('show');
  });
});
</script>
<?php
include('includes/footer.php');
?>