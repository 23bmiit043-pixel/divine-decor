<?php
session_start();
ob_start();

if(!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true) {
    header("Location: admin_login.php");
    exit;
}

include('connect.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
define('TCPDF_DIR', __DIR__ . '/TCPDF-main/');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Product Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><i class="fas fa-box me-2"></i>Product Report Generator</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="reportForm">
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
                                <button type="submit" name="generate_report" class="btn btn-dark w-100">
                                    <i class="fas fa-file-pdf me-2"></i>Generate Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
if(isset($_POST['generate_report'])) {
    try {
        require_once(TCPDF_DIR . 'tcpdf.php');

        $category_id = $_POST['category'];
        $stock_status = $_POST['stock_status'];

        $sql = "SELECT p.*, c.category_name, sc.sub_category_name 
                FROM product p 
                JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id 
                JOIN category c ON sc.category_id = c.category_id";

        $conditions = [];
        if($category_id) {
            $conditions[] = "c.category_id = " . intval($category_id);
        }
        if($stock_status) {
            switch($stock_status) {
                case 'low':
                    $conditions[] = "p.quantity < 10 AND p.quantity > 0";
                    break;
                case 'out':
                    $conditions[] = "p.quantity = 0";
                    break;
                case 'available':
                    $conditions[] = "p.quantity > 0";
                    break;
            }
        }

        if(!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $conn->query($sql);

        $pdf = new TCPDF();
        $pdf->SetTitle('Product Inventory Report');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Product Inventory Report', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);

        // Create table header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(30, 7, 'Product ID', 1, 0, 'C', true);
        $pdf->Cell(50, 7, 'Name', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Category', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Quantity', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Price', 1, 1, 'C', true);

        while($row = $result->fetch_assoc()) {
            $pdf->Cell(30, 6, $row['pid'], 1);
            $pdf->Cell(50, 6, $row['p_name'], 1);
            $pdf->Cell(40, 6, $row['category_name'], 1);
            $pdf->Cell(30, 6, $row['quantity'], 1);
            $pdf->Cell(30, 6, 'Rs ' . number_format($row['p_price'], 2), 1);
            $pdf->Ln();
        }

        $pdf->Output('product_report.pdf', 'D');
        exit();

    } catch(Exception $e) {
        echo "<div class='alert alert-danger'>Error generating report: " . $e->getMessage() . "</div>";
    }
}

include('script.php');
include('includes/footer.php');
?>
