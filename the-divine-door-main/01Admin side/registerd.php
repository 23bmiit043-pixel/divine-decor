<?php
session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');
?>

<div class="content-wrapper">
  <!--Delete Modal-->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="user_code.php" method="POST">
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
            <h1 class="m-0">Registered User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registered Users</li>
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
                <h3 class="card-title">Registered Users-Data
                </h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Customer_id</th>
                    <th>Customer_name</th>
                    <th>Customer_contact</th>
                    <th>Customer_email</th>
                    <th>Customer_address</th>
                    <th>Customer_pincode</th>
                    <th>Options</th>
                  </tr>
                  </thead>
                  <tbody>
              <?php
                      $query="Select * from customer";
                      $query_run=mysqli_query($conn,$query);

                      if(mysqli_num_rows($query_run) >0)
                      {
                          while($row = mysqli_fetch_assoc($query_run))
                          {
                            
                            ?>
                             <tr>
                                        <td><?php echo $row['Cid']; ?></td>
                                        <td><?php echo $row['C_name']; ?></td>
                                        <td><?php echo $row['Contact_no']; ?></td>
                                        <td><?php echo $row['Email']; ?></td>
                                        <td><?php echo $row['Address']; ?></td>
                                        <td><?php echo $row['Area_id']; ?></td>
                                        <td>
                                        <button type="button" value="<?php echo $row['Cid']; ?>" class="btn btn-danger md-sm deletebtn">Delete</button>
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