<?php
/**
 * Razorpay Configuration File
 * 
 * This file contains Razorpay API credentials and configuration.
 * Update these values with your actual Razorpay credentials.
 */

// Razorpay API Keys
define('RAZORPAY_KEY_ID', 'rzp_live_SQirh5HBrAk46P'); // Your Razorpay Key ID (Live)
define('RAZORPAY_KEY_SECRET', 'tAA657L2xkZHcI8aVwglP3Dp'); // Your Razorpay Key Secret (Live)

// Razorpay API Endpoint
define('RAZORPAY_API_URL', 'https://api.razorpay.com');

// Enable/Disable Test Mode (set to false for LIVE payments)
define('RAZORPAY_TEST_MODE', false);

/**
 * Get Razorpay API Headers
 */
function getRazorpayHeaders() {
    return [
        'Authorization' => 'Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET),
        'Content-Type' => 'application/json'
    ];
}

/**
 * Verify Razorpay Payment Signature
 * 
 * @param string $orderId Order ID
 * @param string $paymentId Payment ID
 * @param string $signature Signature from Razorpay
 * @return bool True if signature is valid, false otherwise
 */
function verifyRazorpaySignature($orderId, $paymentId, $signature) {
    // Create the string to hash
    $strToHash = $orderId . '|' . $paymentId;
    
    // Generate the signature
    $generatedSignature = hash_hmac('sha256', $strToHash, RAZORPAY_KEY_SECRET);
    
    // Compare signatures
    return hash_equals($generatedSignature, $signature);
}

/**
 * Create Razorpay Order
 * 
 * @param float $amount Amount in INR
 * @param string $receipt Receipt ID/Order ID
 * @return array Response from Razorpay API
 */
function createRazorpayOrder($amount, $receipt) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => RAZORPAY_API_URL . '/v1/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
            'amount' => $amount * 100, // Convert to paise
            'currency' => 'INR',
            'receipt' => $receipt
        ]),
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return ['error' => $error];
    }

    return json_decode($response, true);
}

/**
 * Fetch Razorpay Payment Details
 * 
 * @param string $paymentId Payment ID from Razorpay
 * @return array Payment details from Razorpay API
 */
function getPaymentDetails($paymentId) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => RAZORPAY_API_URL . '/v1/payments/' . $paymentId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return ['error' => $error];
    }

    return json_decode($response, true);
}
?>
