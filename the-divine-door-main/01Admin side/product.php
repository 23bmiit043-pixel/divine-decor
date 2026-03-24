<?php
session_start();
ob_start(); // Add this at the very top to handle headers
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('connect.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if(isset($_POST['updateproduct']))
    {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $qty = $_POST['qty'];
        $subid = $_POST['subid'];

        // Initialize update query without image
        $query = "UPDATE product SET 
                p_name='$name',
                p_price='$price',
                p_description='$desc',
                quantity='$qty',
                sub_category_id='$subid'
                WHERE pid='$product_id'";

        // Handle image upload if new image is selected
        if(isset($_FILES['image']) && $_FILES['image']['name'] != '') {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $p = rand(1000, 10000) . "." . pathinfo($image_name, PATHINFO_EXTENSION);
            
            if(move_uploaded_file($image_tmp, "../gallery/" . $p)) {
                $query = "UPDATE product SET 
                        p_name='$name',
                        p_price='$price',
                        p_description='$desc',
                        quantity='$qty',
                        p_image='$p',
                        sub_category_id='$subid'
                        WHERE pid='$product_id'";
            }
        }

        $query_run = mysqli_query($conn, $query);
        if($query_run) {
            $_SESSION['status'] = "Product updated successfully";
            header("Location: product.php");
            exit();
        } else {
            $_SESSION['status'] = "Product update failed";
        }
    }
    else if(isset($_POST['addproduct']))
    {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $qty = $_POST['qty'];
        $subid = $_POST['subid'];

        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $p = rand(1000, 10000) . "." . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            
            if(move_uploaded_file($_FILES['image']['tmp_name'], "../gallery/" . $p)) {
                $user_query = "INSERT INTO product(p_name, p_price, p_description, quantity, p_image, sub_category_id) 
                              VALUES('$name', '$price', '$desc', '$qty', '$p', '$subid')";
                $user_query_run = mysqli_query($conn, $user_query);
                
                if($user_query_run) {
                    $_SESSION['status'] = "Product added successfully";
                    header("Location: product.php");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Image upload failed";
            }
        } else {
            $_SESSION['status'] = "Please select an image";
        }
    }
}

if(isset($_POST['DeleteUserBtn']))
{
    $user_id = $_POST['delete_id'];

    // First check if product exists in orders
    $check_query = "SELECT * FROM `order` WHERE pid='$user_id'";
    $check_result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        $_SESSION['status'] = "Cannot delete product - It has existing orders";
        header("Location: product.php");
        exit();
    }

    // If no orders exist, proceed with deletion
    $query = "DELETE FROM product WHERE pid='$user_id'";
    $query_run = mysqli_query($conn, $query);
    
    if($query_run) {
        $_SESSION['status'] = "Product deleted successfully";
        header("Location: product.php");
        exit();
    } else {
        $_SESSION['status'] = "Product deletion failed";
        header("Location: product.php");
        exit();
    }
}

?>

<div class="content-wrapper">

<!--Add Modal-->
<div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="product.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">              
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control" placeholder="Price" required>
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <input type="text" name="desc" class="form-control" placeholder="Description" required>
            </div>
            <div class="form-group">
                <label for="qty">Quantity</label>
                <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="subid">Sub-Category</label>
                <select name="subid" class="form-control" required>
                    <option value="">Select Sub-Category</option>
                    <?php
                    $sub_query = "SELECT * FROM sub_category";
                    $sub_result = mysqli_query($conn, $sub_query);
                    while($sub = mysqli_fetch_assoc($sub_result)) {
                        echo "<option value='".$sub['sub_category_id']."'>".$sub['sub_category_name']."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="addproduct" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--Delete Modal-->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="product.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="delete_id" class="delete_user_id">
        <p>
          Are you sure you want to delete this product?
        </p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="DeleteUserBtn" class="btn btn-primary">Yes, Delete</button>
      </div>
      </form>
      </div>
      </div>
      </div>

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12"></div>
<?php
  if(isset($_SESSION['status']))
  {
    echo"<h4>".$_SESSION['status']."</h4>";
    unset($_SESSION['status']);
  }

?>
    
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product
                </h3>
                <a href="#"  data-bs-toggle="modal" data-bs-target="#AddUserModal" class="btn btn-primary float-right" >Add Product</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Product_id</th>
                    <th>Product</th>
                    <th>price</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Subcategory</th>
                    <th>Options</th>
                  </tr>
                  </thead>
                  <tbody>
              <?php
                      $query = "SELECT p.*, sc.sub_category_name 
                               FROM product p 
                               LEFT JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id";
                      $query_run = mysqli_query($conn, $query);

                      if(mysqli_num_rows($query_run) > 0)
                      {
                          foreach($query_run as $row)
                          {
                            ?>
                             <tr>
                                        <td><?php echo $row['pid']; ?></td>
                                        <td><?php echo $row['p_name']; ?></td>
                                        <td><?php echo $row['p_price']; ?></td>
                                        <td><?php echo $row['p_description']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo '<img src="/The-Divine-Decor/the-divine-door-main/gallery/'.$row['p_image'].'" style="max-width:300px;height:250px;" onclick="gotopage('.$row["pid"].')">';?></td>
                                        <td><?php echo $row['sub_category_name']; ?></td>
                                        <td>
                                            <a href="productedit.php?pid=<?php echo $row['pid']; ?>" class="btn btn-info md-sm">Edit</a>
                                            <button type="button" value="<?php echo $row['pid']; ?>" class="btn btn-danger md-sm deletebtn">Delete</button>
                                        </td>
                                      </tr>
                            <?php
                          }
                      }
                      else
                      {
                        ?>
                        <tr>
                          <td>No Record Found</td>
                          </tr>
                          <?php
                      }
                    ?>
                   </tbody>
                   </table>
                   </div>
                   </div>
                   </div>
                   </div>
                   </section>
                   </div>
<?php include('script.php');?>
<script>
$(document).ready(function () {
  // Use event delegation to handle dynamically loaded content
  $(document).on('click', '.deletebtn', function (e) {
    e.preventDefault();
    
    var user_id = $(this).val();
    //console.log(user_id);
    $('.delete_user_id').val(user_id);
    $('#DeleteModal').modal('show');
  });
});
</script>
<?php
include('includes/footer.php');
?>
