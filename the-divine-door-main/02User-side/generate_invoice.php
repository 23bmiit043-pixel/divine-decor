<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'connect.php';

// Include the TCPDF class from the correct folder
require_once('TCPDF-main/tcpdf.php');

class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Leave empty to remove default header
    }

    // Page footer
    public function Footer() {
        // Leave empty to remove default footer
    }
}

// Get order ID from URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('Order ID not provided');

// Modified query to get all products with same order_details_id
$order_query = "SELECT o.order_id, o.order_date, o.order_details_id,
                c.C_name, c.Address, c.Contact_no,
                p.p_name, p.p_price, o.quantity
                FROM `order` o 
                JOIN customer c ON o.cid = c.Cid
                JOIN product p ON o.pid = p.pid 
                WHERE o.order_details_id = (
                    SELECT order_details_id 
                    FROM `order` 
                    WHERE order_id = ? 
                    LIMIT 1
                )";

$stmt = mysqli_prepare($con, $order_query);
mysqli_stmt_bind_param($stmt, "s", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Store first row for customer info
$first_row = mysqli_fetch_assoc($result);
if(!$first_row) {
    die('Order not found');
}

// Create PDF document
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Use built-in helvetica font instead of DejaVu
$pdf->SetFont('helvetica', '', 10);

// Set PDF properties
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 15);

// Add a page
$pdf->AddPage();

// Reset pointer and process all products
mysqli_data_seek($result, 0);
$total = 0;
$products_html = '';

while($row = mysqli_fetch_assoc($result)) {
    $unit_price = $row['p_price'];
    $quantity = $row['quantity'];
    $subtotal = $unit_price * $quantity;
    $total += $subtotal;
    
    $products_html .= '<tr>
        <td>' . $row['p_name'] . '</td>
        <td style="text-align: center;">' . $quantity . '</td>
        <td style="text-align: right;">INR ' . number_format($unit_price, 2) . '</td>
        <td style="text-align: right;">INR ' . number_format($subtotal, 2) . '</td>
    </tr>';
}

// Build HTML content
$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    .header { background-color: #f8f9fa; padding: 20px; margin-bottom: 20px; }
    .invoice-info { margin-bottom: 20px; }
    .items-table { border: 1px solid #ddd; margin-bottom: 20px; }
    .items-table th { background-color: #f8f9fa; padding: 10px; }
    .items-table td { padding: 8px; border-bottom: 1px solid #ddd; }
</style>

<div class="header">
    <h1 style="text-align: center; color: #2c3e50;">THE DIVINE DECOR</h1>
    <div style="text-align: center;">Your Ultimate Home Decoration Store</div>
</div>

<div class="invoice-info">
    <table>
        <tr>
            <td>
                <strong>Bill To:</strong><br>
                ' . $first_row['C_name'] . '<br>
                ' . $first_row['Address'] . '<br>
                Phone: ' . $first_row['Contact_no'] . '
            </td>
            <td style="text-align: right;">
                <strong>Invoice #:</strong> ' . $order_id . '<br>
                <strong>Date:</strong> ' . date('d/m/Y', strtotime($first_row['order_date'])) . '
            </td>
        </tr>
    </table>
</div>

<table class="items-table">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Amount</th>
    </tr>
    ' . $products_html . '
    <tr>
        <td colspan="3" style="text-align: right;"><strong>Total (Including Delivery):</strong></td>
        <td style="text-align: right;"><strong>INR ' . number_format($total, 2) . '</strong></td>
    </tr>
</table>

<div style="text-align: center; margin-top: 40px;">
    <p><strong>Thank you for your business!</strong></p>
    <p>For any queries, please contact us at support@homedecor.com</p>
</div>';

// Output HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// At the end, flush the buffer before PDF output
ob_end_clean();
$pdf->Output('Invoice_' . $order_id . '.pdf', 'I');
?>
