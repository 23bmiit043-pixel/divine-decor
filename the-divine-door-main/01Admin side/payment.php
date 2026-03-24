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
            <h1 class="m-0">Payment Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment Details</li>
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
            <div class="card admin-table-card">
              <div class="card-header">
                <h3 class="card-title">Payment Details
                </h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive admin-table-shell">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Payment id</th>
                      <th>Customer Name</th>
                      <th>Payment Amount</th>
                      <th>Payment Status</th>
                      <th>Transaction mode</th>
                      <th>Payment date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT payment.*, customer.C_name, `order`.order_amount 
                                 FROM payment 
                                 INNER JOIN `order` ON payment.order_id = `order`.order_id 
                                 INNER JOIN customer ON `order`.cid = customer.Cid";
                        $query_run = mysqli_query($conn,$query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $row)
                            {
                              $transaction_mode = isset($row['transaction_mode']) ? $row['transaction_mode'] : 'N/A';
                              ?>
                               <tr>
                                  <td><?php echo $row['payment_id']; ?></td>
                                  <td><?php echo $row['C_name']; ?></td>
                                  <td>&#8377;<?php echo $row['order_amount']; ?></td>
                                  <td><?php echo $row['payment_status']; ?></td>
                                  <td><?php echo $transaction_mode; ?></td>
                                  <td><?php echo $row['payment_date']; ?></td>
                               </tr>
                              <?php
                            }
                        }
                        else
                        {
                          ?>
                          <tr>
                            <td colspan="6">No Record Found</td>
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
      </div>
</section>
</div>
                    
<?php include('script.php');?>     
                 
<?php
include('includes/footer.php');
?>