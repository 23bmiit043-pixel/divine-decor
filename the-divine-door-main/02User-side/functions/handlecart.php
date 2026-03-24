<?php
ob_start();
error_reporting(0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../connect.php';
include 'myfunctions.php';

function getCartItemCount()
{
    $count = 0;

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cartItem) {
            $count += isset($cartItem['quantity']) ? (int) $cartItem['quantity'] : 0;
        }
    }

    return $count;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method',
    ]);
    exit();
}

$pid = isset($_POST['pid']) ? (int) $_POST['pid'] : 0;
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;

if ($pid <= 0 || $quantity <= 0) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid product or quantity',
    ]);
    exit();
}

$product = getProductById($pid);

if (!$product || mysqli_num_rows($product) === 0) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Product not found',
    ]);
    exit();
}

$productData = mysqli_fetch_assoc($product);
$availableStock = isset($productData['quantity']) ? (int) $productData['quantity'] : 0;

if ($availableStock < 1) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'This product is currently out of stock',
    ]);
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$existingQuantity = isset($_SESSION['cart'][$pid]) ? (int) $_SESSION['cart'][$pid]['quantity'] : 0;
$requestedQuantity = $existingQuantity + $quantity;

if ($requestedQuantity > $availableStock) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => $existingQuantity > 0
            ? 'You already have the maximum available quantity in your cart'
            : 'Requested quantity is not available',
    ]);
    exit();
}

if ($existingQuantity > 0) {
    $_SESSION['cart'][$pid]['quantity'] = $requestedQuantity;
} else {
    $_SESSION['cart'][$pid] = [
        'pid' => $pid,
        'name' => $productData['p_name'],
        'price' => $productData['p_price'],
        'image' => $productData['p_image'],
        'quantity' => $quantity,
    ];
}

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Product added to cart successfully',
    'cartCount' => getCartItemCount(),
]);
exit();
?>
