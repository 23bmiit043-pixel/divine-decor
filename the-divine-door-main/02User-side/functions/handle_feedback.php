<?php
session_start();
include('../connect.php');

if(isset($_POST['submit_feedback'])) {
    // Verify user is logged in
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        echo json_encode(['status' => 'error', 'message' => 'Please login to submit feedback']);
        exit();
    }

    // Get form data
    $pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;
    $cid = $_SESSION['cid'];
    $feedback = isset($_POST['feedback_details']) ? trim($_POST['feedback_details']) : '';

    // Validate inputs
    if($pid <= 0 || empty($feedback)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
        exit();
    }

    try {
        // Prepare the insert statement
        $stmt = $con->prepare("INSERT INTO feedback (cid, pid, feedback_date, feedback_details) VALUES (?, ?, CURRENT_DATE(), ?)");
        $stmt->bind_param("iis", $cid, $pid, $feedback);
        
        // Execute the insert
        if($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Your feedback has been submitted successfully!'
            ]);
        } else {
            throw new Exception('Failed to insert feedback');
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error submitting feedback: ' . $e->getMessage()
        ]);
    }
    exit();
}

// If we get here, it wasn't a valid request
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>
