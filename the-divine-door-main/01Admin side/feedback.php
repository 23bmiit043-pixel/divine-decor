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
            <h1 class="m-0">Feedback Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Feedback Details</li>
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
                <h3 class="card-title">Feedback Details
                </h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Feedback ID</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Feedback Date</th>
                    <th>Feedback Details</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      $query = "SELECT f.feedback_id, f.cid, c.C_name, f.pid, p.p_name, 
                               f.feedback_date, f.feedback_details
                               FROM feedback f
                               LEFT JOIN customer c ON f.cid = c.Cid
                               LEFT JOIN product p ON f.pid = p.pid
                               ORDER BY f.feedback_id";
                      $query_run = mysqli_query($conn, $query);

                      if(mysqli_num_rows($query_run) > 0)
                      {
                          foreach($query_run as $row)
                          {
                            ?>
                             <tr>
                                        <td><?php echo $row['feedback_id']; ?></td>
                                        <td><?php echo $row['cid']; ?></td>
                                        <td><?php echo $row['C_name']; ?></td>
                                        <td><?php echo $row['pid']; ?></td>
                                        <td><?php echo $row['p_name']; ?></td>
                                        <td><?php echo $row['feedback_date']; ?></td>
                                        <td><?php echo $row['feedback_details']; ?></td>
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
                 
 <?php
include('includes/footer.php');
?>

