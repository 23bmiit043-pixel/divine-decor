<?php
session_start();
include('connect.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Edit Offer</h4>
    <div class="card mt-4 shadow-lg">
        <div class="card-header">
            <h4>Edit Offer Details</h4>
        </div>
        <div class="card-body">
            <?php
            if(isset($_GET['offer_id'])) {
                $offer_id = mysqli_real_escape_string($conn, $_GET['offer_id']);
                $query = "SELECT * FROM offer WHERE offer_id='$offer_id'";
                $query_run = mysqli_query($conn, $query);

                if(mysqli_num_rows($query_run) > 0) {
                    $offer = mysqli_fetch_array($query_run);
                    ?>
                    <form action="offer_code.php" method="POST">
                        <input type="hidden" name="offer_id" value="<?= $offer['offer_id']; ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Coupon Code</label>
                                <input type="text" name="coupone_code" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Start Date</label>
                                <input type="date" name="start_date" value="<?= $offer['start_date']; ?>" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>End Date</label>
                                <input type="date" name="end_date" value="<?= $offer['end_date']; ?>" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Discount Amount</label>
                                <input type="number" name="discount_amt" value="<?= $offer['discount_amt']; ?>" class="form-control" step="0.01" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Offer Description</label>
                                <textarea name="Offer_discription" class="form-control" required rows="4"><?= $offer['Offer_discription']; ?></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Minimum Amount</label>
                                <input type="number" name="min_ant" value="<?= $offer['min_ant']; ?>" class="form-control" step="0.01" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <button type="submit" name="update_offer" class="btn btn-primary">Update Offer</button>
                                <a href="productoffer.php" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <h4>No Record Found</h4>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>