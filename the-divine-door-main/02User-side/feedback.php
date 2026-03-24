<?php
if(!isset($product_id)) {
    exit();
}

$user_has_reviewed = false;
$user_review = null;
$can_review = false;

// Check if user has ordered and can review
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $user_id = $_SESSION['cid'];
    
    // Check if user has purchased the product
    $order_check = mysqli_query($con, 
        "SELECT * FROM `order` 
         WHERE cid = $user_id 
         AND pid = $product_id 
         AND order_status != 'Cancelled'");
    $can_review = mysqli_num_rows($order_check) > 0;
    
    // Check if user has already reviewed
    $existing_review = mysqli_query($con, 
        "SELECT f.*, c.C_name 
         FROM feedback f 
         JOIN customer c ON f.cid = c.Cid 
         WHERE f.cid = $user_id AND f.pid = $product_id");
    
    if($existing_review && mysqli_num_rows($existing_review) > 0) {
        $user_has_reviewed = true;
        $user_review = mysqli_fetch_assoc($existing_review);
    }
}

// Get all other feedback
$feedback_query = "SELECT f.*, c.C_name 
                  FROM feedback f 
                  JOIN customer c ON f.cid = c.Cid 
                  WHERE f.pid = $product_id 
                  " . ($user_has_reviewed ? "AND f.cid != $user_id" : "") . "
                  ORDER BY f.feedback_date DESC";
$feedback_result = mysqli_query($con, $feedback_query);
?>

<section class="feedback-section py-5 bg-light">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">Customer Feedback</h2>
        
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <?php if($can_review): ?>
                <?php if($user_has_reviewed): ?>
                    <!-- Show user's existing review -->
                    <div class="card mb-4 border-success">
                        <div class="card-header bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle"></i> Your Review
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="card-subtitle"><?= htmlspecialchars($user_review['C_name']) ?> (You)</h6>
                                <small class="text-muted">
                                    <?= date('F d, Y', strtotime($user_review['feedback_date'])) ?>
                                </small>
                            </div>
                            <p class="card-text"><?= htmlspecialchars($user_review['feedback_details']) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Show feedback form -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Write Your Review</h5>
                            <form id="feedbackForm" method="POST">
                                <input type="hidden" name="pid" value="<?= $product_id ?>">
                                <input type="hidden" name="submit_feedback" value="1">
                                <div class="mb-3">
                                    <textarea class="form-control" name="feedback_details" 
                                            rows="3" required 
                                            placeholder="Share your experience with this product"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="card mb-4 border-warning">
                    <div class="card-header bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-exclamation-circle"></i> Purchase Required
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            You need to purchase this product before you can write a review. 
                            Your honest feedback helps our community!
                        </p>
                        <button class="btn btn-warning" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                            <i class="fas fa-shopping-cart"></i> Buy Now
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="card mb-4 border-info">
                <div class="card-header bg-info bg-opacity-10 text-info">
                    <i class="fas fa-user-circle"></i> Login Required
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Please log in to share your experience with this product. 
                        Your review matters to us and other customers!
                    </p>
                    <a href="login.php" class="btn btn-info text-white">
                        <i class="fas fa-sign-in-alt"></i> Login to Review
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Other customer reviews -->
        <div class="feedback-list mt-4">
            <h5 class="mb-3">Other Customer Reviews</h5>
            <?php if(mysqli_num_rows($feedback_result) > 0): ?>
                <?php while($feedback = mysqli_fetch_assoc($feedback_result)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="card-subtitle text-muted"><?= htmlspecialchars($feedback['C_name']) ?></h6>
                                <small class="text-muted">
                                    <?= date('F d, Y', strtotime($feedback['feedback_date'])) ?>
                                </small>
                            </div>
                            <p class="card-text"><?= htmlspecialchars($feedback['feedback_details']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-4">
                    <p class="text-muted mb-0">No other reviews yet for this product.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
const feedbackForm = document.getElementById('feedbackForm');

if (feedbackForm) {
    feedbackForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('functions/handle_feedback.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting your feedback');
        });
    });
}
</script>
