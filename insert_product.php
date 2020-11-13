<?php
require_once('database.php');

$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$product_name = filter_input(INPUT_POST, 'product_name');
$product_code = filter_input(INPUT_POST, 'product_code');
$list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);

if (empty($product_name)) {
    $name_error = 'name must not be emptry';
} else {
    $name_error = '';
}
if (empty($product_code)) {
    $code_error = 'code must not be emptry';
} else {
    $code_error = '';
}
if (empty($list_price)) {
    $price_error = 'price must not be emptry';
} else if ($list_price < 0 || $list_price > 50000) {
    $price_error = "list price should be btw 0 and 50000";
} else {
    $price_error = '';
}

if (!empty($name_error) || !empty($code_error) || !empty($price_error)) {
    include('add_product_form.php');
    exit();
}

// insert query
$insertQuery = "INSERT INTO products
                    (categoryID, productCode, productName, listPrice)
                VALUES ($category_id, $product_code, $product_name, $list_price)";
$statement = $db->prepare($insertQuery);
$statement->execute();
$statement->closeCursor();

include('index.php');
