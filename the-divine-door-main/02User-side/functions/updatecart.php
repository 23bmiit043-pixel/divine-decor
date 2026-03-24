<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../connect.php';

function getAvailableStock($pid)
{
    global $con;

    $query = "SELECT quantity FROM product WHERE pid = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $pid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return (int) $row['quantity'];
    }

    return 0;
}

function calculateTotal()
{
    $total = 0;

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += (float) $item['price'] * (int) $item['quantity'];
        }
    }

    return $total;
}

function getCartItemCount()
{
    $count = 0;

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += isset($item['quantity']) ? (int) $item['quantity'] : 0;
        }
    }

    return $count;
}

header('Content-Type: application/json');

$action = isset($_POST['action']) ? $_POST['action'] : '';
$pid = isset($_POST['pid']) ? (int) $_POST['pid'] : 0;

if ($pid <= 0 || $action === '') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request',
    ]);
    exit();
}

if (!isset($_SESSION['cart'][$pid])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Product not found in cart',
    ]);
    exit();
}

$availableStock = getAvailableStock($pid);

switch ($action) {
    case 'increase':
        if ($_SESSION['cart'][$pid]['quantity'] >= $availableStock) {
            echo json_encode([
                'status' => 'success',
                'newQuantity' => (int) $_SESSION['cart'][$pid]['quantity'],
                'maxQuantity' => $availableStock,
                'newSubtotal' => number_format($_SESSION['cart'][$pid]['price'] * $_SESSION['cart'][$pid]['quantity'], 2),
                'newTotal' => number_format(calculateTotal(), 2),
                'cartCount' => getCartItemCount(),
            ]);
            exit();
        }

        $_SESSION['cart'][$pid]['quantity']++;
        break;

    case 'decrease':
        if ($_SESSION['cart'][$pid]['quantity'] > 1) {
            $_SESSION['cart'][$pid]['quantity']--;
        }
        break;

    case 'remove':
        unset($_SESSION['cart'][$pid]);
        echo json_encode([
            'status' => 'success',
            'newQuantity' => 0,
            'newSubtotal' => number_format(0, 2),
            'newTotal' => number_format(calculateTotal(), 2),
            'cartCount' => getCartItemCount(),
            'maxQuantity' => $availableStock,
        ]);
        exit();

    default:
        echo json_encode([
            'status' => 'error',
            'message' => 'Unsupported cart action',
        ]);
        exit();
}

$item = $_SESSION['cart'][$pid];
$subtotal = (float) $item['price'] * (int) $item['quantity'];

echo json_encode([
    'status' => 'success',
    'newQuantity' => (int) $item['quantity'],
    'newSubtotal' => number_format($subtotal, 2),
    'newTotal' => number_format(calculateTotal(), 2),
    'cartCount' => getCartItemCount(),
    'maxQuantity' => $availableStock,
]);
exit();
?>
