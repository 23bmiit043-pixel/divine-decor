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
                    <h1 class="m-0">Sales Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><i class="fas fa-chart-line me-2"></i>Sales Report Generator</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="reportForm">
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

        $report_type = $_POST['report_type'];
        $month_year = $_POST['month_year'] ?? date('Y-m');

        $sql = "SELECT DATE(o.order_date) as sale_date,
                COUNT(DISTINCT o.order_id) as num_orders,
                SUM(o.order_amount) as total_sales,
                COUNT(DISTINCT o.cid) as num_customers
                FROM `order` o
                WHERE o.order_status = 'Completed'";

        switch($report_type) {
            case 'daily':
                $sql .= " AND DATE(o.order_date) = CURDATE()
                         GROUP BY DATE(o.order_date)";
                break;
            case 'weekly':
                $sql .= " AND YEARWEEK(o.order_date) = YEARWEEK(CURDATE())
                         GROUP BY DATE(o.order_date)";
                break;
            case 'monthly':
                $month = date('m', strtotime($month_year));
                $year = date('Y', strtotime($month_year));
                $sql .= " AND MONTH(o.order_date) = $month 
                         AND YEAR(o.order_date) = $year
                         GROUP BY DATE(o.order_date)";
                break;
            case 'yearly':
                $year = date('Y', strtotime($month_year));
                $sql .= " AND YEAR(o.order_date) = $year
                         GROUP BY MONTH(o.order_date)";
                break;
        }

        $result = $conn->query($sql);

        $pdf = new TCPDF();
        $pdf->SetTitle('Sales Report');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Sales Report - ' . ucfirst($report_type), 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);

        // Create table header
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(40, 7, 'Date', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Orders', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Total Sales', 1, 0, 'C', true);
        $pdf->Cell(40, 7, 'Customers', 1, 1, 'C', true);

        $total_sales = 0;
        $total_orders = 0;
        while($row = $result->fetch_assoc()) {
            $pdf->Cell(40, 6, $row['sale_date'], 1);
            $pdf->Cell(30, 6, $row['num_orders'], 1);
            $pdf->Cell(40, 6, '$' . number_format($row['total_sales'], 2), 1);
            $pdf->Cell(40, 6, $row['num_customers'], 1);
            $pdf->Ln();
            
            $total_sales += $row['total_sales'];
            $total_orders += $row['num_orders'];
        }

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(70, 7, 'Totals:', 1, 0, 'R');
        $pdf->Cell(40, 7, '$' . number_format($total_sales, 2), 1, 0, 'L');
        $pdf->Cell(40, 7, $total_orders . ' orders', 1, 1, 'L');

        $pdf->Output('sales_report.pdf', 'D');
        exit();

    } catch(Exception $e) {
        echo "<div class='alert alert-danger'>Error generating report: " . $e->getMessage() . "</div>";
    }
}

include('script.php');
include('includes/footer.php');
?>
