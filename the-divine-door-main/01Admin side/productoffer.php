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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Product-Offer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="offer_code.php" method="POST">
      <div class="modal-body">
        <div class="form-group">
            <label for="Name">Offer Id</label>
            <input type="text" name="offer_id" class="form-control" placeholder="Offer-Id">
        </div>
        <div class="form-group">
            <label for="Name">Coupon Code</label>
            <input type="text" name="coupone_code" class="form-control" placeholder="Coupon Code">
        </div>
        <div class="form-group">
            <label for="Name">Offer Start-Date</label>
            <input type="date" name="offer_startdate" class="form-control" placeholder="Offer Start-Date">
        </div>
        <div class="form-group">
            <label for="Name">Offer End-Date</label>
            <input type="date" name="offer_enddate" class="form-control" placeholder="Offer End-Date">
        </div>
        <div class="form-group">
            <label for="Name">Offer Amount</label>
            <input type="number" name="offer_amt" class="form-control" placeholder="Offer Amount">
        </div>
        <div class="form-group">
            <label for="Name">Offer Description</label>
            <input type="text" name="offer_desc" class="form-control" placeholder="Offer Description">
        </div>
        <div class="form-group">
            <label for="Name">Minimum Amount</label>
            <input type="number" name="min_amt" class="form-control" placeholder="Minimum Amount">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addoffer" class="btn btn-primary">Save changes</button>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Offer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="offer_code.php" method="POST">
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
            <h1 class="m-0">Product Offer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Offer</li>
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
          <div class="col-12"></div>
    
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Offer Details
                </h3>
                <a href="#"  data-bs-toggle="modal" data-bs-target="#AddCategoryModal" class="btn btn-primary float-right" >Add product offer</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Offer ID</th>
                    <th>Coupon Code</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Discount Amount</th>
                    <th>Description</th>
                    <th>Min Amount</th>
                    <th>Options</th> 
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      $query="Select * from offer";
                      $query_run=mysqli_query($conn,$query);

                      if(mysqli_num_rows($query_run) >0)
                      {
                          foreach($query_run as $row)
                          {
                            
                            ?>
                             <tr>
                                        <td><?php echo $row['offer_id']; ?></td>
                                        <td><?php echo $row['coupone_code']; ?></td>
                                        <td><?php echo $row['start_date']; ?></td>
                                        <td><?php echo $row['end_date']; ?></td>
                                        <td><?php echo $row['discount_amt']; ?></td>
                                        <td><?php echo $row['Offer_discription']; ?></td>
                                        <td><?php echo $row['min_ant']; ?></td>
                                        <td>
                                          <a href="offeredit.php?offer_id=<?php echo $row['offer_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                          <button type="button" value="<?php echo $row['offer_id']; ?>" class="btn btn-danger md-sm deletebtn">Delete</button>
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

