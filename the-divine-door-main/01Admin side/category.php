<?php

session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');
?>

<div class="content-wrapper">

<div class="modal fade" id="AddCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
  <form action="category_code.php" method="POST">
      <div class="modal-body">
        <div class="form-group">
            <label for="Name">Category Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name">
            <!-- <div class="form-group">
                <label for="image">Image</label>
                <input type="file" action="category_code.php"name="image" class="form-control" accept="image/*" required>
            </div> -->


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addcategory" class="btn btn-primary">Save changes</button>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="category_code.php" method="POST">
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
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
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
          <div class="col-12">
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Category Details
                </h3>
                <a href="#"  data-bs-toggle="modal" data-bs-target="#AddCategoryModal" class="btn btn-primary float-right" >Add Category</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Category_id</th>
                    <th>Category_name</th>
                    <!-- <th>Image</th> -->
                    <th>Options</th> 
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      $query="Select * from category";
                      $query_run=mysqli_query($conn,$query);

                      if(mysqli_num_rows($query_run) >0)
                      {
                          foreach($query_run as $row)
                          {
                            
                            ?>
                             <tr>
                                        <td><?php echo $row['category_id']; ?></td>
                                        <td><?php echo $row['category_name']; ?></td>
                                        <!-- <td><php echo '<img src="../gallery/'.$row['image'].'" style="max-width:300px;height:250px;">'; ?></td> -->
                                        <td>                                        
                                          <a href="categoryedit.php?category_id=<?php echo $row['category_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                          <button type="button" value="<?php echo $row['category_id']; ?>" class="btn btn-danger md-sm deletebtn">Delete</button>
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
