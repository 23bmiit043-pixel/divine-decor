<?php
session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');
?>
<style>
    #example1{  box-sizing: border-box !important;
                overflow-x: auto !important; white-space: nowrap !important;
                text-overflow: ellipsis !important;
                 overflow: hidden !important;
                 table-layout: fixed !important;
                  
                 }
</style>
<div class="content-wrapper">
<!--Add Modal-->
<div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Delivery Person</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="delivery_code.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
            <label for="Name">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" name="password" class="form-control" placeholder="password" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" class="form-control" placeholder="Contact" required>
        </div> 
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div> 
        <div class="form-group">
            <label for="idproof">Id-Proof</label>
            <input type="file" name="idproof" class="form-control" accept="image/*" required>
        </div> 
        <div class="form-group">
            <label for="profileimg">Profile-Image</label>
            <input type="file" name="profileimg" class="form-control" accept="image/*" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="addDelivery" class="btn btn-primary">Save changes</button>
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
      <form action="delivery_code.php" method="POST">
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
            <h1 class="m-0">Delivery_person</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Delivery_Person</li>
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
                <h3 class="card-title">Delivery_person-Data
                </h3>  
                <a href="#"  data-bs-toggle="modal" data-bs-target="#AddUserModal" class="btn btn-primary float-right" >Add Delivery Person</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Idproof</th>
                    <th>Profileimg</th>
                    <th>Options</th>
                  </tr>
                  </thead>
                  <tbody>
              <?php
                      $query="Select * from delivery_person";
                      $query_run=mysqli_query($conn,$query);

                      if(mysqli_num_rows($query_run) >0)
                      {
                          foreach($query_run as $row)
                          {
                            ?>
                             <tr>
                                        <td><?php echo $row['delivery_person_id']; ?></td>
                                        <td><?php echo $row['Name']; ?></td>
                                        <td><?php echo isset($row['password']) ? $row['password'] : 'N/A'; ?></td>
                                        <td><?php echo $row['Contact_no']; ?></td>
                                        <td><?php echo $row['Email']; ?></td>
                                        <td><?php echo '<img src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/Images/deliveryperson/'.$row['Id-proof'].'" style="max-width:100px;height:80px;">'; ?></td>
                                        <td><?php echo '<img src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/Images/deliveryperson/'.$row['Photo'].'" style="max-width:100px;height:80px;">'; ?></td>
                                        <td>
                                        <a href="deliverypersonedit.php?delivery_person_id=<?php echo $row['delivery_person_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                            <button type="button" value="<?php echo $row['delivery_person_id']; ?>" class="btn btn-danger md-sm deletebtn">Delete</button>
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