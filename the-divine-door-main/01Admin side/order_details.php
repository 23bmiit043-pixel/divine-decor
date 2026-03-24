<?php
session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');

if(isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // Get initial order info and order_details_id
    $query = "SELECT o.*, c.C_name as customer_name, c.Email as customer_email,
              od.p_price as original_price, od.quantity as total_quantity, od.order_date as group_order_date
              FROM `order` o
              LEFT JOIN customer c ON o.cid = c.Cid
              LEFT JOIN order_details od ON o.order_details_id = od.order_details_id
              WHERE o.order_id = '$order_id'";
              
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_array($result);
    
    $order_details_id = $order['order_details_id'];
    
    // Get all products from orders with same order_details_id
    $products_query = "SELECT o.*, 
                             p.p_name, p.p_price, p.p_image, p.p_description,
                             c.C_name as customer_name, c.Email as customer_email,
                             sc.sub_category_name,
                             cat.category_name
                      FROM `order` o
                      LEFT JOIN product p ON o.pid = p.pid
                      LEFT JOIN customer c ON o.cid = c.Cid
                      LEFT JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id
                      LEFT JOIN category cat ON sc.category_id = cat.category_id
                      WHERE o.order_details_id = '$order_details_id'
                      ORDER BY o.order_date DESC";
                      
    $products_result = mysqli_query($conn, $products_query);
    
    // Reset and calculate totals once
    $total_amount = 0;
    $total_items = 0;
    while($prod = mysqli_fetch_array($products_result)) {
        $total_amount += $prod['order_amount'];
        $total_items += $prod['quantity'];
    }
    mysqli_data_seek($products_result, 0);
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Details #<?php echo $order_id; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="order.php">Orders</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer Information</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?php echo $order['customer_name']; ?></p>
                            <p><strong>Email:</strong> <?php echo $order['customer_email']; ?></p>
                            <p><strong>Contact:</strong> <?php echo $order['Contact_no']; ?></p>
                            <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Information</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                            <p><strong>Order Status:</strong> <?php echo $order['order_status']; ?></p>
                            <p><strong>Order Details ID:</strong> <?php echo $order_details_id; ?></p>
                            <p><strong>Total Items:</strong> <?php echo $total_items; ?></p>
                            <p><strong>Total Amount:</strong> ₹<?php echo number_format($total_amount + 50, 2); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Information</h3>
                        </div>
                        <div class="card-body">
                            <?php 
                            mysqli_data_seek($products_result, 0);
                            while($product = mysqli_fetch_array($products_result)) { 
                            ?>
                            <div class="product-details mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="/The-Divine-Decor/the-divine-door-main/gallery/<?php echo $product['p_image']; ?>" 
                                             class="img-fluid rounded" alt="<?php echo $product['p_name']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <h5><?php echo $product['p_name']; ?></h5>
                                        <p class="mb-1"><?php echo $product['p_description']; ?></p>
                                        <small class="text-muted">
                                            <?php echo $product['category_name']; ?> > 
                                            <?php echo $product['sub_category_name']; ?>
                                        </small>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mb-1"><strong>Quantity:</strong></p>
                                        <h6><?php echo $product['quantity']; ?></h6>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mb-1"><strong>Unit Price:</strong></p>
                                        <h6>₹<?php echo number_format($product['p_price'], 2); ?></h6>
                                        <?php if(isset($product['original_price']) && $product['original_price'] != $product['p_price']): ?>
                                            <small class="text-muted">Original: ₹<?php echo number_format($product['original_price'], 2); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mb-1"><strong>Total:</strong></p>
                                        <h6>₹<?php echo number_format($product['order_amount'], 2); ?></h6>
                                        <span class="badge <?php echo ($product['order_status'] == 'Completed') ? 'bg-success' : 'bg-warning'; ?>">
                                            <?php echo $product['order_status']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php } ?>
                            
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <div class="text-end">
                                        <h5>Order Summary</h5>
                                        <p><strong>Subtotal:</strong> ₹<?php echo number_format($total_amount, 2); ?></p>
                                        <p><strong>Delivery Charge:</strong> ₹50.00</p>
                                        <h4><strong>Total Amount:</strong> ₹<?php echo number_format($total_amount + 50, 2); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <a href="order.php" class="btn btn-secondary">Back to Orders</a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
