<?php
include('config.php');

// Get available delivery persons
function getDeliveryPersons() {
    global $conn;
    $sql = "SELECT dp.delivery_person_id, dp.Name, dp.is_available, 
            GROUP_CONCAT(da.area_name) as areas 
            FROM delivery_person dp 
            LEFT JOIN delivery_areas da ON dp.delivery_person_id = da.delivery_person_id 
            WHERE dp.is_available = 1 
            GROUP BY dp.delivery_person_id";
    return $conn->query($sql);
}

// Update delivery assignment
if(isset($_POST['assign_delivery'])) {
    $order_id = $_POST['order_id'];
    $delivery_person_id = $_POST['delivery_person_id'];
    
    $sql = "UPDATE `order` SET 
            delivery_person_id = ?,
            order_status = 'Assigned' 
            WHERE order_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $delivery_person_id, $order_id);
    
    if($stmt->execute()) {
        echo "Delivery person assigned successfully";
    } else {
        echo "Error assigning delivery person";
    }
}

// HTML for the delivery person dropdown
function getDeliveryPersonDropdown($order_id) {
    $result = getDeliveryPersons();
    $html = "<form method='POST'>";
    $html .= "<input type='hidden' name='order_id' value='$order_id'>";
    $html .= "<select name='delivery_person_id' required>";
    $html .= "<option value=''>Select Delivery Person</option>";
    
    while($row = $result->fetch_assoc()) {
        $html .= "<option value='".$row['delivery_person_id']."'>";
        $html .= $row['Name']." (Areas: ".$row['areas'].")";
        $html .= "</option>";
    }
    
    $html .= "</select>";
    $html .= "<button type='submit' name='assign_delivery'>Assign</button>";
    $html .= "</form>";
    return $html;
}
?>

<!-- Example usage in your order management page -->
<div class="delivery-assignment">
    <h3>Assign Delivery Person</h3>
    <?php
    // Example: Display dropdown for a specific order
    $order_id = 1; // Replace with actual order ID
    echo getDeliveryPersonDropdown($order_id);
    ?>
</div>

<style>
.delivery-assignment {
    margin: 20px;
    padding: 15px;
    border: 1px solid #ddd;
}

select {
    padding: 8px;
    margin-right: 10px;
    min-width: 200px;
}

button {
    padding: 8px 15px;
    background: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background: #45a049;
}
</style>
