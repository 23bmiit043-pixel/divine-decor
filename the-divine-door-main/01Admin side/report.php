<?php
session_start();
ob_start();

// Check if user is logged in
if(!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true) {
    header("Location: admin_login.php");
    exit;
}

if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('connect.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
define('TCPDF_DIR', __DIR__ . '/TCPDF-main/');

?>

<style>
.small-box {
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
    box-shadow: 0 3px 10px rgba(15, 23, 42, 0.3);
    border-radius: 4px;
}

.small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.4);
}

.content-header {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reports Generator</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Report Type Selection -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-dark" onclick="showReport('customer')">Customer Report</button>
                        <button type="button" class="btn btn-dark" onclick="showReport('product')">Product Report</button>
                        <button type="button" class="btn btn-dark" onclick="showReport('order')">Order Report</button>
                        <button type="button" class="btn btn-dark" onclick="showReport('sales')">Sales Report</button>
                    </div>
                </div>
            </div>

            <!-- Customer Report Form -->
            <div id="customerReport" class="report-section">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-users me-2"></i>Customer Report Generator</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="report.php" method="POST" id="reportForm" class="needs-validation" novalidate>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" name="from_date" id="from_date" class="form-control" required>
                                        <label for="from_date">From Date</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" name="to_date" id="to_date" class="form-control" required>
                                        <label for="to_date">To Date</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="report" class="btn btn-dark" style="background-color: #212529;" id="generateBtn">
                                            <i class="fas fa-file-pdf me-2"></i>Download PDF
                                        </button>
                                        <button type="submit" name="show_report" class="btn" style="background-color: #212529; color: white;" id="showBtn">
                                            <i class="fas fa-eye me-2"></i>Show Report
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Report Display Section -->
                <div class="card mt-4 <?php echo (!isset($_POST['show_report'])) ? 'd-none' : ''; ?>">
                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #212529;">
                        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Report Preview</h5>
                        
                    </div>
                    <div class="card-body table-responsive">
                        <?php if(isset($_POST['show_report'])): ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>Gender</th>
                                        <th>Total Orders</th>
                                        <th>Total Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $from_date = $_POST['from_date'] ?? '';
                                    $to_date = $_POST['to_date'] ?? '';
                                    $result = getCustomerReportData($conn, $from_date, $to_date);
                                    while($row = $result->fetch_assoc()): 
                                    ?>
                                    <tr>
                                        <td><?php echo $row['Cid']; ?></td>
                                        <td><?php echo $row['C_name']; ?></td>
                                        <td><?php echo $row['Email']; ?></td>
                                        <td><?php echo $row['Address']; ?></td>
                                        <td><?php echo $row['Contact_no']; ?></td>
                                        <td><?php echo $row['Gender']; ?></td>
                                        <td><?php echo $row['total_orders']; ?></td>
                                        <td><?php echo number_format($row['total_spent'], 2); ?> Rs.</td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Product Report Form -->
            <div id="productReport" class="report-section" style="display:none">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-box me-2"></i>Product Report Generator</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select name="category" class="form-select">
                                        <option value="">All Categories</option>
                                        <?php
                                        $cat_query = "SELECT * FROM category";
                                        $cat_result = $conn->query($cat_query);
                                        while($cat = $cat_result->fetch_assoc()) {
                                            echo "<option value='".$cat['category_id']."'>".$cat['category_name']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="stock_status" class="form-select">
                                        <option value="">All Stock Status</option>
                                        <option value="low">Low Stock (< 10)</option>
                                        <option value="out">Out of Stock</option>
                                        <option value="available">Available</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="product_report" class="btn btn-dark" style="background-color: #212529;" id="generateProductBtn">
                                            <i class="fas fa-file-pdf me-2"></i>Download PDF
                                        </button>
                                        <button type="submit" name="show_product_report" class="btn" style="background-color: #212529; color: white;" id="showProductBtn">
                                            <i class="fas fa-eye me-2"></i>Show Report
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Product Report Display Section -->
                <div class="card mt-4 <?php echo (!isset($_POST['show_product_report'])) ? 'd-none' : ''; ?>">
                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #212529;">
                        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Product Report Preview</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <?php if(isset($_POST['show_product_report'])): 
                            $category_id = $_POST['category'];
                            $stock_status = $_POST['stock_status'];
                            
                            $sql = "SELECT p.*, c.category_name, sc.sub_category_name 
                                    FROM product p 
                                    JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id 
                                    JOIN category c ON sc.category_id = c.category_id";

                            if ($category_id) {
                                $sql .= " WHERE c.category_id = '$category_id'";
                            }

                            if ($stock_status) {
                                if ($category_id) {
                                    $sql .= " AND";
                                } else {
                                    $sql .= " WHERE";
                                }
                                if ($stock_status == 'low') {
                                    $sql .= " p.quantity < 10";
                                } elseif ($stock_status == 'out') {
                                    $sql .= " p.quantity = 0";
                                } else {
                                    $sql .= " p.quantity > 0";
                                }
                            }

                            $result = $conn->query($sql);
                        ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['pid']; ?></td>
                                        <td><?php echo $row['p_name']; ?></td>
                                        <td><?php echo $row['category_name']; ?></td>
                                        <td><?php echo $row['sub_category_name']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo number_format($row['p_price'], 2); ?> Rs.</td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Order Report Form -->
            <div id="orderReport" class="report-section" style="display:none">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Report Generator</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <input type="date" name="order_from_date" class="form-control" required>
                                    <label>From Date</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="order_to_date" class="form-control" required>
                                    <label>To Date</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="order_status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="order_report" class="btn btn-dark" style="background-color: #212529;" id="generateOrderBtn">
                                            <i class="fas fa-file-pdf me-2"></i>Download PDF
                                        </button>
                                        <button type="submit" name="show_order_report" class="btn" style="background-color: #212529; color: white;" id="showOrderBtn">
                                            <i class="fas fa-eye me-2"></i>Show Report
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Report Display Section -->
                <div class="card mt-4 <?php echo (!isset($_POST['show_order_report'])) ? 'd-none' : ''; ?>">
                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #212529;">
                        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Order Report Preview</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <?php if(isset($_POST['show_order_report'])): 
                            $from_date = $_POST['order_from_date'];
                            $to_date = $_POST['order_to_date'];
                            $order_status = $_POST['order_status'];

                            $sql = "SELECT o.order_id, c.C_name, p.p_name, o.order_date, o.order_amount, o.order_status
                                    FROM `order` o
                                    JOIN customer c ON o.cid = c.Cid
                                    JOIN product p ON o.pid = p.pid
                                    WHERE o.order_date BETWEEN '$from_date' AND '$to_date'";

                            if ($order_status) {
                                $sql .= " AND o.order_status = '$order_status'";
                            }

                            $result = $conn->query($sql);
                        ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['order_id']; ?></td>
                                        <td><?php echo $row['C_name']; ?></td>
                                        <td><?php echo $row['p_name']; ?></td>
                                        <td><?php echo date('F d, Y', strtotime($row['order_date'])); ?></td>
                                        <td><?php echo number_format($row['order_amount'], 2); ?> Rs.</td>
                                        <td><?php echo $row['order_status']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sales Report Form -->
            <div id="salesReport" class="report-section" style="display:none">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-chart-line me-2"></i>Sales Report Generator</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select name="report_type" class="form-select" required>
                                        <option value="daily">Daily Sales</option>
                                        <option value="weekly">Weekly Sales</option>
                                        <option value="monthly">Monthly Sales</option>
                                        <option value="yearly">Yearly Sales</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="month" name="month_year" class="form-control">
                                    <small class="text-muted">Required for monthly/yearly reports</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-grid gap-2">
                                        <button type="submit" name="sales_report" class="btn btn-dark" style="background-color: #212529;" id="generateSalesBtn">
                                            <i class="fas fa-file-pdf me-2"></i>Download PDF
                                        </button>
                                        <button type="submit" name="show_sales_report" class="btn" style="background-color: #212529; color: white;" id="showSalesBtn">
                                            <i class="fas fa-eye me-2"></i>Show Report
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sales Report Display Section -->
                <div class="card mt-4 <?php echo (!isset($_POST['show_sales_report'])) ? 'd-none' : ''; ?>">
                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #212529;">
                        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Sales Report Preview</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <?php if(isset($_POST['show_sales_report'])): 
                            $report_type = $_POST['report_type'];
                            $month_year = $_POST['month_year'] ?? date('Y-m');

                            $sql = "SELECT DATE_FORMAT(o.order_date, '%Y-%m-%d') as date,
                                   COUNT(o.order_id) as total_orders,
                                   COUNT(DISTINCT o.cid) as total_customers,
                                   SUM(o.order_amount) as total_sales
                                   FROM `order` o";

                            if ($report_type == 'daily') {
                                $sql .= " WHERE DATE_FORMAT(o.order_date, '%Y-%m-%d') = CURDATE()";
                            } elseif ($report_type == 'weekly') {
                                $sql .= " WHERE YEARWEEK(o.order_date, 1) = YEARWEEK(CURDATE(), 1)";
                            } elseif ($report_type == 'monthly') {
                                $sql .= " WHERE DATE_FORMAT(o.order_date, '%Y-%m') = '$month_year'";
                            } elseif ($report_type == 'yearly') {
                                $sql .= " WHERE YEAR(o.order_date) = YEAR(CURDATE())";
                            }

                            $sql .= " GROUP BY date ORDER BY date ASC";
                            $result = $conn->query($sql);
                        ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Orders</th>
                                        <th>Customers</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('F d, Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['total_orders']; ?></td>
                                        <td><?php echo $row['total_customers']; ?></td>
                                        <td><?php echo number_format($row['total_sales'], 2); ?> Rs.</td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reportForm');
    const fromDate = document.getElementById('from_date');
    const toDate = document.getElementById('to_date');

    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    fromDate.max = today;
    toDate.max = today;

    // Date validation
    fromDate.addEventListener('change', function() {
        toDate.min = this.value;
    });

    toDate.addEventListener('change', function() {
        fromDate.max = this.value;
    });

    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});

function showReport(type) {
    // Hide all report sections
    document.querySelectorAll('.report-section').forEach(section => {
        section.style.display = 'none';
    });
    // Show selected report section
    document.getElementById(type + 'Report').style.display = 'block';
}
</script>

<?php
// Function to fetch customer report data
function getCustomerReportData($conn, $from_date = null, $to_date = null) {
    $sql = "SELECT c.Cid, c.C_name, c.Email, c.Address, c.Contact_no, c.Gender,
            COUNT(o.order_id) as total_orders,
            SUM(o.order_amount) as total_spent
            FROM customer c
            LEFT JOIN `order` o ON c.Cid = o.cid";
    
    if ($from_date && $to_date) {
        $sql .= " WHERE o.order_date BETWEEN ? AND ?";
        $sql .= " GROUP BY c.Cid";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $from_date, $to_date);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    $sql .= " GROUP BY c.Cid";
    return $conn->query($sql);
}

// Function to generate PDF report
function generatePDFReport($result, $from_date = null, $to_date = null) {
    // Initialize TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document properties
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('The Divine Decor');
    $pdf->SetTitle('Customer Report');
    $pdf->SetHeaderData(false, 0, 'The Divine Decor', 'Customer Report - ' . date('d-m-Y'));
    
    // Set margins and breaks
    $pdf->SetMargins(15, 25, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    $pdf->SetAutoPageBreak(TRUE, 25);
    
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 14);
    
    // Add report header
    $pdf->Cell(0, 10, 'Customer Report', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Generated on: ' . date('F d, Y'), 0, 1, 'C');
    
    if ($from_date && $to_date) {
        $pdf->Cell(0, 10, 'Date Range: ' . date('F d, Y', strtotime($from_date)) . 
                         ' to ' . date('F d, Y', strtotime($to_date)), 0, 1, 'C');
    }
    
    // Generate table content
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Ln(10);
    
    $html = '<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">';
    $html .= '<thead><tr style="background-color: #f0f0f0;">';
    
    while ($fieldinfo = $result->fetch_field()) {
        $html .= '<th style="font-weight: bold;">' . $fieldinfo->name . '</th>';
    }
    $html .= '</tr></thead><tbody>';
    
    $rowCount = 0;
    while ($row = $result->fetch_assoc()) {
        $bgColor = $rowCount % 2 ? '#ffffff' : '#f9f9f9';
        $html .= '<tr style="background-color: ' . $bgColor . '">';
        foreach ($row as $value) {
            $html .= '<td>' . htmlspecialchars($value) . '</td>';
        }
        $html .= '</tr>';
        $rowCount++;
    }
    $html .= '</tbody></table>';
    
    $pdf->writeHTML($html, true, false, true, false, '');
    return $pdf;
}

// Main execution logic
try {
    // Check TCPDF installation
    if (!file_exists(TCPDF_DIR . 'tcpdf.php')) {
        throw new Exception("TCPDF is not installed. Please install it in: " . TCPDF_DIR);
    }
    require_once(TCPDF_DIR . 'tcpdf.php');

    if (isset($_POST['report'])) {
        $from_date = $_POST['from_date'] ?? '';
        $to_date = $_POST['to_date'] ?? '';
        
        // Validate dates if provided
        if (($from_date && !$to_date) || (!$from_date && $to_date)) {
            throw new Exception("Please provide both From and To dates");
        }
        
        $result = getCustomerReportData($conn, $from_date, $to_date);
        if (!$result) {
            throw new Exception('Database query error: ' . $conn->error);
        }
        
        $pdf = generatePDFReport($result, $from_date, $to_date);
        ob_end_clean();
        $pdf->Output('customer_report_' . date('Y-m-d') . '.pdf', 'D');
        exit();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}

if(isset($_POST['product_report'])) {
    try {
        require_once(TCPDF_DIR . 'tcpdf.php');
        
        $category_id = $_POST['category'];
        $stock_status = $_POST['stock_status'];

        $sql = "SELECT p.*, c.category_name, sc.sub_category_name 
                FROM product p 
                JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id 
                JOIN category c ON sc.category_id = c.category_id";

        if ($category_id) {
            $sql .= " WHERE c.category_id = '$category_id'";
        }

        if ($stock_status) {
            if ($category_id) {
                $sql .= " AND";
            } else {
                $sql .= " WHERE";
            }
            if ($stock_status == 'low') {
                $sql .= " p.quantity < 10";
            } elseif ($stock_status == 'out') {
                $sql .= " p.quantity = 0";
            } else {
                $sql .= " p.quantity > 0";
            }
        }

        $result = $conn->query($sql);
        
        // Initialize TCPDF like customer report
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('The Divine Decor');
        $pdf->SetTitle('Product Inventory Report');
        $pdf->SetHeaderData(false, 0, 'The Divine Decor', 'Product Report - ' . date('d-m-Y'));
        $pdf->SetMargins(15, 25, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);
        
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Product Inventory Report', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Generated on: ' . date('F d, Y'), 0, 1, 'C');
        
        // Generate table content
        $pdf->SetFont('helvetica', '', 10, '', true);
        $pdf->Ln(10);
        
        $html = '<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">';
        $html .= '<thead><tr style="background-color: #f0f0f0;">';
        $html .= '<th style="font-weight: bold;">Product ID</th>';
        $html .= '<th style="font-weight: bold;">Name</th>';
        $html .= '<th style="font-weight: bold;">Category</th>';
        $html .= '<th style="font-weight: bold;">Sub Category</th>';
        $html .= '<th style="font-weight: bold;">Quantity</th>';
        $html .= '<th style="font-weight: bold;">Price</th>';
        $html .= '</tr></thead><tbody>';
        
        $rowCount = 0;
        while ($row = $result->fetch_assoc()) {
            $bgColor = $rowCount % 2 ? '#ffffff' : '#f9f9f9';
            $html .= '<tr style="background-color: ' . $bgColor . '">';
            $html .= '<td>' . $row['pid'] . '</td>';
            $html .= '<td>' . $row['p_name'] . '</td>';
            $html .= '<td>' . $row['category_name'] . '</td>';
            $html .= '<td>' . $row['sub_category_name'] . '</td>';
            $html .= '<td>' . $row['quantity'] . '</td>';
            $html .= '<td>' . number_format($row['p_price'], 2) . ' Rs.</td>';
            $html .= '</tr>';
            $rowCount++;
        }
        $html .= '</tbody></table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output('product_report_' . date('Y-m-d') . '.pdf', 'D');
        exit();

    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}

if(isset($_POST['order_report'])) {
    try {
        require_once(TCPDF_DIR . 'tcpdf.php');
        
        $from_date = $_POST['order_from_date'];
        $to_date = $_POST['order_to_date'];
        $order_status = $_POST['order_status'];

        $sql = "SELECT o.order_id, c.C_name, p.p_name, o.order_date, o.order_amount, o.order_status
                FROM `order` o
                JOIN customer c ON o.cid = c.Cid
                JOIN product p ON o.pid = p.pid
                WHERE o.order_date BETWEEN '$from_date' AND '$to_date'";

        if ($order_status) {
            $sql .= " AND o.order_status = '$order_status'";
        }

        $result = $conn->query($sql);

        // Initialize TCPDF like customer report
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('The Divine Decor');
        $pdf->SetTitle('Order Report');
        $pdf->SetHeaderData(false, 0, 'The Divine Decor', 'Order Report - ' . date('d-m-Y'));
        $pdf->SetMargins(15, 25, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);
        
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Order Report', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Generated on: ' . date('F d, Y'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Period: ' . date('F d, Y', strtotime($from_date)) . 
                         ' to ' . date('F d, Y', strtotime($to_date)), 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(10);
        
        $html = '<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">';
        $html .= '<thead><tr style="background-color: #f0f0f0;">';
        $html .= '<th style="font-weight: bold;">Order ID</th>';
        $html .= '<th style="font-weight: bold;">Customer</th>';
        $html .= '<th style="font-weight: bold;">Product</th>';
        $html .= '<th style="font-weight: bold;">Date</th>';
        $html .= '<th style="font-weight: bold;">Amount</th>';
        $html .= '<th style="font-weight: bold;">Status</th>';
        $html .= '</tr></thead><tbody>';
        
        $rowCount = 0;
        while ($row = $result->fetch_assoc()) {
            $bgColor = $rowCount % 2 ? '#ffffff' : '#f9f9f9';
            $html .= '<tr style="background-color: ' . $bgColor . '">';
            $html .= '<td>' . $row['order_id'] . '</td>';
            $html .= '<td>' . $row['C_name'] . '</td>';
            $html .= '<td>' . $row['p_name'] . '</td>';
            $html .= '<td>' . date('F d, Y', strtotime($row['order_date'])) . '</td>';
            $html .= '<td>' . number_format($row['order_amount'], 2) . ' Rs.</td>';
            $html .= '<td>' . $row['order_status'] . '</td>';
            $html .= '</tr>';
            $rowCount++;
        }
        $html .= '</tbody></table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output('order_report_' . date('Y-m-d') . '.pdf', 'D');
        exit();

    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}

if(isset($_POST['sales_report'])) {
    try {
        require_once(TCPDF_DIR . 'tcpdf.php');
        
        $report_type = $_POST['report_type'];
        $month_year = $_POST['month_year'] ?? date('Y-m');

        $sql = "SELECT DATE_FORMAT(o.order_date, '%Y-%m-%d') as date, 
                       COUNT(o.order_id) as total_orders, 
                       COUNT(DISTINCT o.cid) as total_customers, 
                       SUM(o.order_amount) as total_sales
                FROM `order` o";

        if ($report_type == 'daily') {
            $sql .= " WHERE DATE_FORMAT(o.order_date, '%Y-%m-%d') = CURDATE()";
        } elseif ($report_type == 'weekly') {
            $sql .= " WHERE YEARWEEK(o.order_date, 1) = YEARWEEK(CURDATE(), 1)";
        } elseif ($report_type == 'monthly') {
            $sql .= " WHERE DATE_FORMAT(o.order_date, '%Y-%m') = '$month_year'";
        } elseif ($report_type == 'yearly') {
            $sql .= " WHERE YEAR(o.order_date) = YEAR(CURDATE())";
        }

        $sql .= " GROUP BY date ORDER BY date ASC";

        $result = $conn->query($sql);

        // Initialize TCPDF like customer report
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('The Divine Decor');
        $pdf->SetTitle('Sales Report');
        $pdf->SetHeaderData(false, 0, 'The Divine Decor', 'Sales Report - ' . date('d-m-Y'));
        $pdf->SetMargins(15, 25, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);
        
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Sales Report - ' . ucfirst($report_type), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Generated on: ' . date('F d, Y'), 0, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(10);
        
        $html = '<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">';
        $html .= '<thead><tr style="background-color: #f0f0f0;">';
        $html .= '<th style="font-weight: bold;">Date</th>';
        $html .= '<th style="font-weight: bold;">Orders</th>';
        $html .= '<th style="font-weight: bold;">Customers</th>';
        $html .= '<th style="font-weight: bold;">Total Sales</th>';
        $html .= '</tr></thead><tbody>';
        
        $rowCount = 0;
        while ($row = $result->fetch_assoc()) {
            $bgColor = $rowCount % 2 ? '#ffffff' : '#f9f9f9';
            $html .= '<tr style="background-color: ' . $bgColor . '">';
            $html .= '<td>' . date('F d, Y', strtotime($row['date'])) . '</td>';
            $html .= '<td>' . $row['total_orders'] . '</td>';
            $html .= '<td>' . $row['total_customers'] . '</td>';
            $html .= '<td>' . number_format($row['total_sales'], 2) . ' Rs.</td>';
            $html .= '</tr>';
            $rowCount++;
        }
        $html .= '</tbody></table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output('sales_report_' . date('Y-m-d') . '.pdf', 'D');
        exit();

    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}

include('script.php');
include('includes/footer.php');
?>
