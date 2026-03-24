<?php
require_once __DIR__ . '/../connect.php';

function getAll($table)
{
    global $con;
    $query = "SELECT * FROM $table";
    return mysqli_query($con, $query);
}

function getById($table, $id)
{
    global $con;
    $query = "SELECT * FROM $table WHERE id = $id";
    return mysqli_query($con, $query);
}

function getAllActive($table)
{
    global $con;
    $query = "SELECT * FROM $table";
    return mysqli_query($con, $query);
}

function getSubCategories($category_id) {
    global $con;
    $category_id = (int) $category_id;
    $query = "SELECT * FROM sub_category WHERE category_id = '$category_id'";
    return mysqli_query($con, $query);
}

function getProductsByCategory($category_id, $subcategory_id = null) {
    global $con;
    $category_id = (int) $category_id;
    if($subcategory_id) {
        $subcategory_id = (int) $subcategory_id;
        $query = "SELECT * FROM product WHERE sub_category_id = '$subcategory_id'";
    } else {
        // Here 'p' is an alias for 'product' table
        $query = "SELECT p.* FROM product p 
                  INNER JOIN sub_category s ON p.sub_category_id = s.sub_category_id 
                  WHERE s.category_id = '$category_id'";
    }
    return mysqli_query($con, $query);
}

function getProductById($product_id) {
    global $con;
    $product_id = (int) $product_id;
    // Here 'p' is an alias for 'product' table
    $query = "SELECT p.*, c.category_name, sc.sub_category_name, sc.sub_category_id, sc.category_id
              FROM product p 
              LEFT JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id
              LEFT JOIN category c ON sc.category_id = c.category_id
              WHERE p.pid = '$product_id'";
    return mysqli_query($con, $query);
}

function getRelatedProducts($product_id, $sub_category_id, $limit = 4) {
    global $con;
    $product_id = (int) $product_id;
    $sub_category_id = (int) $sub_category_id;
    $limit = (int) $limit;
    // Here 'p' is an alias for 'product' table
    $query = "SELECT p.*, sc.sub_category_name 
              FROM product p
              INNER JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id
              WHERE p.sub_category_id = '$sub_category_id' 
              AND p.pid != '$product_id'
              LIMIT $limit";
    return mysqli_query($con, $query);
}

function getProductsBySubCategory($sub_category_id, $exclude_product_id = null) {
    global $con;
    $sub_category_id = (int) $sub_category_id;
    $query = "SELECT p.*, sc.sub_category_name 
              FROM product p
              INNER JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id
              WHERE p.sub_category_id = '$sub_category_id'";
    
    if($exclude_product_id) {
        $exclude_product_id = (int) $exclude_product_id;
        $query .= " AND p.pid != '$exclude_product_id'";
    }
    
    $result = mysqli_query($con, $query);
    return $result;
}

function getCatalogProducts($category_id = 0, $subcategory_id = 0, $search_term = '')
{
    global $con;

    $category_id = (int) $category_id;
    $subcategory_id = (int) $subcategory_id;
    $search_term = trim((string) $search_term);

    $query = "SELECT p.*, sc.sub_category_name, sc.category_id, c.category_name
              FROM product p
              LEFT JOIN sub_category sc ON p.sub_category_id = sc.sub_category_id
              LEFT JOIN category c ON sc.category_id = c.category_id
              WHERE 1=1";

    $types = '';
    $params = [];

    if ($subcategory_id > 0) {
        $query .= " AND p.sub_category_id = ?";
        $types .= 'i';
        $params[] = $subcategory_id;
    } elseif ($category_id > 0) {
        $query .= " AND sc.category_id = ?";
        $types .= 'i';
        $params[] = $category_id;
    }

    if ($search_term !== '') {
        $like_term = '%' . $search_term . '%';
        $prefix_term = $search_term . '%';
        $word_term = '% ' . $search_term . '%';
        $query .= " AND p.p_name LIKE ?";
        $types .= 's';
        $params[] = $like_term;

        $query .= " ORDER BY CASE
                      WHEN p.p_name = ? THEN 0
                      WHEN p.p_name LIKE ? THEN 1
                      WHEN p.p_name LIKE ? THEN 2
                      ELSE 3
                    END,
                    CHAR_LENGTH(p.p_name) ASC,
                    p.p_name ASC,
                    p.pid DESC";
        $types .= 'sss';
        $params[] = $search_term;
        $params[] = $prefix_term;
        $params[] = $word_term;
    } else {
        $query .= " ORDER BY p.pid DESC";
    }

    $statement = mysqli_prepare($con, $query);

    if (!$statement) {
        return false;
    }

    if ($types !== '') {
        mysqli_stmt_bind_param($statement, $types, ...$params);
    }

    mysqli_stmt_execute($statement);

    return mysqli_stmt_get_result($statement);
}

function getFeaturedProducts()
{
    global $con;
    $query = "SELECT * FROM products WHERE status='0' AND trending='1' LIMIT 8";
    return mysqli_query($con, $query);
}

function getMostPurchasedProducts()
{
    global $con;
    $query = "SELECT p.*,
                     COALESCE(SUM(CASE WHEN o.order_status != 'Cancelled' THEN o.quantity ELSE 0 END), 0) AS purchase_count
              FROM product p
              LEFT JOIN `order` o ON p.pid = o.pid
              GROUP BY p.pid
              ORDER BY purchase_count DESC, p.quantity DESC, p.pid DESC
              LIMIT 8";
    return mysqli_query($con, $query);
}

function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header('Location: ' .$url);
    exit(0);
}

?>
