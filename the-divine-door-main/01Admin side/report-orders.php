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
                    <h1 class="m-0">Order Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Order Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Report Generator</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="reportForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="date" name="from_date" class="form-control" required>
                                <label>From Date</label>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="to_date" class="form-control" required>
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

        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $order_status = $_POST['order_status'];

        $sql = "SELECT o.*, c.C_name, p.p_name 
                FROM `order` o
                JOIN customer c ON o.cid = c.Cid
                JOIN product p ON o.pid = p.pid
                WHERE o.order_date BETWEEN ? AND ?";

        if($order_status) {
            $sql .= " AND o.order_status = ?";
        }

        $stmt = $conn->prepare($sql);
        
        if($order_status) {
            $stmt->bind_param("sss", $from_date, $to_date, $order_status);
        } else {
            $stmt->bind_param("ss", $from_date, $to_date);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();

        $pdf = new TCPDF();
        $pdf->SetTitle('Order Report');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Order Report', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);

        // Create table header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(25, 7, 'Order ID', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Customer', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Product', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Amount', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Status', 1, 1, 'C', true);

        $total_amount = 0;
        while($row = $result->fetch_assoc()) {
            $pdf->Cell(25, 6, $row['order_id'], 1);
            $pdf->Cell(40, 6, $row['C_name'], 1);
            $pdf->Cell(40, 6, $row['p_name'], 1);
            $pdf->Cell(30, 6, '$' . number_format($row['order_amount'], 2), 1);
            $pdf->Cell(30, 6, $row['order_status'], 1);
            $pdf->Ln();
            
            $total_amount += $row['order_amount'];
        }

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(105, 7, 'Total Amount:', 1, 0, 'R');
        $pdf->Cell(60, 7, '$' . number_format($total_amount, 2), 1, 1, 'L');

        $pdf->Output('order_report.pdf', 'D');
        exit();

    } catch(Exception $e) {
        echo "<div class='alert alert-danger'>Error generating report: " . $e->getMessage() . "</div>";
    }
}

include('script.php');
include('includes/footer.php');
?>
