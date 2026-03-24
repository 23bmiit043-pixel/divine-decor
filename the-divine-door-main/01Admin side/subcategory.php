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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Sub-category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="subcategory_code.php" method="POST">
      <div class="modal-body">
        <div class="form-group">
            <label for="category">Category Name</label>
            <select name="category_id" class="form-control">
                <option value="">Select Category</option>
                <?php
                $category_query = "SELECT * FROM category";
                $category_result = mysqli_query($conn, $category_query);
                if(mysqli_num_rows($category_result) > 0) {
                    foreach($category_result as $category) {
                        ?>
                        <option value="<?= $category['category_id']; ?>"><?= $category['category_name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Name">Sub-Category Name</label>
            <input type="text" name="sub_category_name" class="form-control" placeholder="Sub-Category Name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addsubcategory" class="btn btn-primary">Save changes</button>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Sub-Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="subcategory_code.php" method="POST">
        <div class="modal-body">
          <input type="hidden" name="delete_id" class="delete_user_id">
          <p>Are you sure you want to delete this sub-category?</p>
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
            <h1 class="m-0">Sub-category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sub-category</li>
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
                <h3 class="card-title">Sub-category Details
                </h3>
                <a href="#"  data-bs-toggle="modal" data-bs-target="#AddCategoryModal" class="btn btn-primary float-right" >Add Sub-category</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
    <div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sub-category_id</th>
                <th>Sub-category_name</th>
                <th>Category_id</th>
                <th>Options</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT sc.*, c.category_name 
                     FROM sub_category sc 
                     LEFT JOIN category c ON c.category_id = sc.category_id";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['sub_category_id']; ?></td>
                        <td><?php echo $row['sub_category_name']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td>
                            <a href="subcategoryedit.php?sub_category_id=<?php echo $row['sub_category_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <button type="button" value="<?php echo $row['sub_category_id']; ?>" class="btn btn-danger md-sm deletebtn">Delete</button>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="4">No Record Found</td>
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
                   </div>
                   </section>
                   </div>
                    
                   <?php include('script.php');?>     
                   <script>
$(document).ready(function () {
  // Use event delegation for dynamically loaded content
  $(document).on('click', '.deletebtn', function (e) {
    e.preventDefault();
    
    var user_id = $(this).val();
    $('.delete_user_id').val(user_id);
    $('#DeleteModal').modal('show');
  });
});
</script>             
 <?php
include('includes/footer.php');
?>
