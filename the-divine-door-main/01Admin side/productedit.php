<?php

session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');
?>
<div class="content-wrapper">
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <?php
  if(isset($_SESSION['status']))
  {
    echo"<h4>".$_SESSION['status']."</h4>";
    unset($_SESSION['status']);
  }

?>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12"></div>

    
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Product
                </h3>
                <a href="product.php"   class="btn btn-danger float-right" >Back</a>
              </div>
              <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                    <form action="product.php" method="POST" enctype="multipart/form-data">
                    
      <div class="modal-body">
        <?php
        if(isset($_GET['pid']))
        {
            $product_id=$_GET['pid'];
            $query="SELECT p.*, sc.sub_category_name
                    FROM product p 
                    LEFT JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id 
                    WHERE p.pid='$product_id' LIMIT 1";
            $query_run=mysqli_query($conn,$query);
            if(mysqli_num_rows($query_run)>0)
            {
                foreach($query_run as $row)
                {
                        
                    ?>
<input type="hidden" name="product_id" value="<?php echo $row['pid'] ?>">
<div class="form-group">

                      
                     <div class="form-group">
                 <label for="Name">Name</label>
                    <input type="text" name="name" value="<?php echo $row['p_name'] ?>" class="form-control" placeholder="Product Name" required>
                     </div>
                     <div class="form-group">
                 <label for="Price">Price</label>
                    <input type="number" name="price" value="<?php echo $row['p_price'] ?>" class="form-control" placeholder="Product price" required min="0" step="0.01">
                     </div>
                     <div class="form-group">
                 <label for="desc">Description</label>
                    <textarea name="desc" class="form-control" placeholder="Product Description" required><?php echo $row['p_description'] ?></textarea>
                     </div>
                     <div class="form-group">
                 <label for="qty">Quantity</label>
                    <input type="number" name="qty" value="<?php echo $row['quantity'] ?>" class="form-control" placeholder="Product Quantity" required min="0">
                     </div>
                     <div class="form-group">
                 <label for="image">Image</label>
                    <input type="file" name="image" class="form-control" accept=".jpg, .jpeg, .png">
                    <?php if($row['p_image']): ?>
                        <img src="/The-Divine-Decor/the-divine-door-main/gallery/<?php echo $row['p_image'] ?>" width="100px" class="mt-2">
                    <?php endif; ?>
                     </div>
                     <div class="form-group">
                 <label for="subid">Sub-category</label>
                    <select name="subid" class="form-control" required>
                        <?php
                        $sub_query = "SELECT * FROM sub_category";
                        $sub_result = mysqli_query($conn, $sub_query);
                        while($subcategory = mysqli_fetch_assoc($sub_result)) {
                            $selected = ($subcategory['sub_category_id'] == $row['sub_category_id']) ? 'selected' : '';
                            echo "<option value='".$subcategory['sub_category_id']."' ".$selected.">".$subcategory['sub_category_name']."</option>";
                        }
                        ?>
                    </select>
                     </div>
                    <?php
                }
            }
            else
            {
                echo "<h4>No Record Found.</h4>";
            }
        }
       
        ?>
      </div>
      <div class="modal-footer">
        
        <button type="submit" name="updateproduct" class="btn btn-info">Update</button>
      </div>
      
      </form>
      
                    </div>
                </div>
                </div>
                </div>
                </div>

</div>
</section>
</div>
<?php include('script.php');?>

<?php
include('includes/footer.php');
?>
