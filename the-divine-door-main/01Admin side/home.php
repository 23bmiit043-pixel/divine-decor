<?php
include('connect.php');
include('header.php');
include('topbar.php');
?>


<div class="product-section">
			<div class="container">
				<div class="row">

					<!-- Start Column 1 -->
					<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
						<h2 class="mb-4 section-title">Great deals and offers.</h2>
						<p class="mb-4">At PIXEL PERIPHERALS, we bring you the best in computer accessories to enhance your productivity, gaming experience, and overall digital lifestyle. Whether you're a professional, student, or gamer, we have everything you need to optimize your setup. </p>
						<p><a href="shop.html" class="btn">Explore</a></p>
					</div> 
					<!-- End Column 1 -->

					<!-- Start Column 2 -->
                    <?php
                            $query="Select * from product where offer_id=1";
                            $query_run=mysqli_query($conn,$query);
      
                            if(mysqli_num_rows($query_run) >0)
                            {
                                foreach($query_run as $row)
                                {

                                                            
                            ?>
					<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
						<a class="product-item" href="cart.html">
                            
							<img src="<?php echo $row['p_image']; ?>" class="img-fluid product-thumbnail">
							<h3 class="product-title"><?php echo $row['p_name']; ?></h3>
							<strong class="product-price"><?php echo $row['p_price']; ?></strong>

							<span class="icon-cross">
								<img src="/The-Divine-Decor/the-divine-door-main/01Admin%20side/Images/cross.svg" class="img-fluid">
							</span>
                           
						</a>
					</div> 
                    <?php
                          }
                      }
                      ?>
                    
                    </div>
                    </div>
                    </div>
                    

<?php
include('footer.php');
?>