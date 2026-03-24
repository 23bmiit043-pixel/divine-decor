<?php
session_start();
include("connect.php");
?>

<div class="form-group">
    <label>Coupon Code</label>
    <input type="text" name="coupon_code" class="form-control" required>
</div>

<div class="form-group">
    <label>Start Date</label>
    <input type="date" name="start_date" class="form-control" required>
</div>

<div class="form-group">
    <label>End Date</label>
    <input type="date" name="end_date" class="form-control" required>
</div>

<div class="form-group">
    <label>Discount Amount</label>
    <input type="number" name="discount_amt" class="form-control" step="0.01" required>
</div>

<div class="form-group">
    <label>Offer Description</label>
    <textarea name="offer_description" class="form-control" required></textarea>
</div>

<div class="form-group">
    <label>Minimum Amount</label>
    <input type="number" name="min_amt" class="form-control" step="0.01" required>
</div>
