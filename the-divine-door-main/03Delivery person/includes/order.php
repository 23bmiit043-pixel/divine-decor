<?php
session_start();

// Process Delete Request
if(isset($_GET['delete_id'])) {
    require 'connect.php';
    $order_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM `order` WHERE order_id='$order_id'";
    $delete_query_run = mysqli_query($conn, $delete_query);
    
    if($delete_query_run) {
        $_SESSION['status'] = "Order Deleted Successfully";
    } else {
        $_SESSION['status'] = "Order Deletion Failed";
    }
    header("Location: order.php");
    exit();
}

// Process Update Request
if(isset($_POST['update_order'])) {
    require 'connect.php';
    $order_details_id = $_POST['order_details_id'];
    $order_status = $_POST['order_status'];
    $quantity = $_POST['quantity'];
    $p_price = $_POST['p_price'];
    $delivery_person_id = $_POST['delivery_person_id'];
    
    // Update orders with this order_details_id
    if(!empty($delivery_person_id)) {
        $update_orders = "UPDATE `order` SET order_status='$order_status', 
                         delivery_person_id='$delivery_person_id',
                         assigned_at=NOW() 
                         WHERE order_details_id='$order_details_id'";
    } else {
        $update_orders = "UPDATE `order` SET order_status='$order_status', 
                         delivery_person_id=NULL,
                         assigned_at=NULL 
                         WHERE order_details_id='$order_details_id'";
    }
    mysqli_query($conn, $update_orders);

    // Update order_details
    $update_details = "UPDATE order_details SET p_price='$p_price', quantity='$quantity'
                      WHERE order_details_id='$order_details_id'";
    $update_query_run = mysqli_query($conn, $update_details);

    if($update_query_run) {
        $_SESSION['status'] = "Order Updated Successfully";
    } else {
        $_SESSION['status'] = "Order Update Failed";
    }
    header("Location: order.php");
    exit();
}

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');

// Show Edit Modal
if(isset($_GET['edit_id'])) {
    $order_id = $_GET['edit_id'];
    $edit_query = "SELECT * FROM `order` WHERE order_id='$order_id'";
    $edit_query_run = mysqli_query($conn, $edit_query);
    $order = mysqli_fetch_array($edit_query_run);
}
?>
<div class="content-wrapper">

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Order Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order Details</li>
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
                <h3 class="card-title">Order Details
                </h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order Details ID</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Delivery Person</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      $query = "SELECT DISTINCT od.order_details_id, od.p_price, od.quantity, od.order_date,
                               o.order_id, o.order_status, dp.Name as delivery_person_name
                               FROM order_details od
                               LEFT JOIN `order` o ON o.order_details_id = od.order_details_id 
                               LEFT JOIN delivery_person dp ON o.delivery_person_id = dp.delivery_person_id
                               GROUP BY od.order_details_id
                               ORDER BY od.order_date DESC";
                      $query_run = mysqli_query($conn, $query);

                      if(mysqli_num_rows($query_run) > 0)
                      {
                          foreach($query_run as $row)
                          {
                            ?>
                             <tr>
                                <td>#<?php echo $row['order_details_id']; ?></td>
                                <td>₹<?php echo number_format($row['p_price'], 2); ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo date("d M Y", strtotime($row['order_date'])); ?></td>
                                <td><?php 
                                    if($row['order_status'] == 'Cancelled') {
                                        echo 'N/A';
                                    } else {
                                        echo $row['delivery_person_name'] ? $row['delivery_person_name'] : 'Not Assigned';
                                    }
                                ?></td>
                                <td>
                                    <span class="badge <?php echo ($row['order_status'] == 'Completed') ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo htmlspecialchars($row['order_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="order_details.php?id=<?php echo $row['order_id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['order_details_id']; ?>">
                                        Edit
                                    </button>
                                    <a href="?delete_id=<?php echo $row['order_details_id']; ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Are you sure you want to delete this order detail?')">Delete</a>
                                    
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['order_details_id']; ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Order Detail</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="order_details_id" value="<?php echo $row['order_details_id']; ?>">
                                                        
                                                        <div class="form-group">
                                                            <label>Delivery Person</label>
                                                            <select name="delivery_person_id" class="form-control" <?php echo ($row['order_status'] == 'Cancelled') ? 'disabled' : ''; ?>>
                                                                <option value="">Select Delivery Person</option>
                                                                <?php
                                                                if($row['order_status'] != 'Cancelled') {
                                                                    $delivery_query = "SELECT delivery_person_id, Name FROM delivery_person WHERE is_available = 1";
                                                                    $delivery_result = mysqli_query($conn, $delivery_query);
                                                                    while($delivery_person = mysqli_fetch_assoc($delivery_result)) {
                                                                        $selected = ($delivery_person['delivery_person_id'] == $row['delivery_person_id']) ? 'selected' : '';
                                                                        echo "<option value='".$delivery_person['delivery_person_id']."' ".$selected.">".$delivery_person['Name']."</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>Order Status</label>
                                                            <select name="order_status" class="form-control">
                                                                <option value="Pending" <?php echo ($row['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="Processing" <?php echo ($row['order_status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                                                <option value="Completed" <?php echo ($row['order_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                                <option value="Cancelled" <?php echo ($row['order_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>Quantity</label>
                                                            <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" class="form-control">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>Product Price</label>
                                                            <input type="number" name="p_price" value="<?php echo $row['p_price']; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="update_order" class="btn btn-primary">Update Order</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                             </tr>
                            <?php
                          }
                      }
                      else
                      {
                        ?>
                        <tr>
                          <td colspan="7">No Record Found</td>
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

