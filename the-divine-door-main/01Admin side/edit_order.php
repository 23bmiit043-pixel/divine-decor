<?php
session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');

if(isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];
    $quantity = $_POST['quantity'];
    $order_amount = $_POST['order_amount'];
    
    $query = "UPDATE `order` SET order_status='$order_status', quantity='$quantity', 
              order_amount='$order_amount' WHERE order_id='$order_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['status'] = "Order Updated Successfully";
        header("Location: order.php");
        exit;
    } else {
        $_SESSION['status'] = "Order Update Failed";
        header("Location: order.php");
        exit;
    }
}

$order_id = $_GET['id'];
$query = "SELECT * FROM `order` WHERE order_id='$order_id'";
$query_run = mysqli_query($conn, $query);

if(mysqli_num_rows($query_run) > 0) {
    $order = mysqli_fetch_array($query_run);
?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>Edit Order</h1>
                <form action="" method="POST">
                    <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                    
                    <div class="form-group">
                        <label>Order Status</label>
                        <select name="order_status" class="form-control">
                            <option value="Pending" <?= ($order['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Processing" <?= ($order['order_status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                            <option value="Completed" <?= ($order['order_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Cancelled" <?= ($order['order_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" value="<?= $order['quantity']; ?>" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Order Amount</label>
                        <input type="number" name="order_amount" value="<?= $order['order_amount']; ?>" class="form-control">
                    </div>
                    
                    <button type="submit" name="update_order" class="btn btn-primary">Update Order</button>
                </form>
            </div>
        </div>
    </div>
<?php
}
include('includes/footer.php');
?>
