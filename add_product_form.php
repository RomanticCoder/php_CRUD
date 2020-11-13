<?php
require_once('database.php');

if (!isset($category_id)) {
    $category_id = '';
}
if (!isset($product_code)) {
    $product_code = '';
}
if (!isset($list_price)) {
    $list_price = '';
}
if (!isset($product_name)) {
    $product_name = '';
}

// Get all categories
$queryAllCategories = 'SELECT * FROM categories
                           ORDER BY categoryID';
$statement = $db->prepare($queryAllCategories);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

?>


<!--                    HTML                    -->

<head>
    <title>add product form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="main.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<!-- the body section -->

<body>
    <main>
        <h1>Product Manager</h1>
        <aside>
            <form action="insert_product.php" method="post" class="form">
                <h2>Add Product</h2>

                <div class="form-group">
                    <label for="categoryID">Category ID:</label>
                    <?php if (!empty($category_error)) { ?>
                        <p class="text-danger"><?php echo htmlspecialchars($category_error); ?></p>
                    <?php } ?>
                    <select class="form-control" id="categorySelect" name="category_id">
                        <?php foreach ($categories as $category) :  ?>

                            <option value="<?php echo $category['categoryID']; ?>" <?php if ($category_id == $category['categoryID']) {
                                                                                        echo "selected";
                                                                                    } ?>><?php echo $category['categoryName']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- here!! -->
                    <!-- <input type="text" class="form-conrol" id="categoryID" name="category_id" value="<?php echo htmlspecialchars($category_id); ?>"> -->
                </div>

                <div class="form-group">
                    <label for="productCode">Product Code:</label>
                    <?php if (!empty($code_error)) { ?>
                        <p class="text-danger"><?php echo htmlspecialchars($code_error); ?></p>
                    <?php } ?>
                    <input type="text" class="form-conrol" id="productCode" name="product_code" value="<?php echo htmlspecialchars($product_code); ?>">
                </div>

                <div class="form-group">
                    <label for="productName">Product name:</label>
                    <?php if (!empty($name_error)) { ?>
                        <p class="text-danger"><?php echo htmlspecialchars($name_error); ?></p>
                    <?php } ?>
                    <input type="text" class="form-conrol" id="productName" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
                </div>

                <div class="form-group">
                    <label for="listPrice">List price:</label>
                    <?php if (!empty($price_error)) { ?>
                        <p class="text-danger"><?php echo htmlspecialchars($price_error); ?></p>
                    <?php } ?>
                    <input type="text" class="form-conrol" id="listPrice" name="list_price" value="<?php echo htmlspecialchars($list_price); ?>">
                </div>



                <input class="btn bg-success text-white" type="submit" value="Add Product">
            </form>
            <a href="index.php">View Product List</a>
    </main>
    <footer>By GyeongEun Lee</footer>
</body>

</html>