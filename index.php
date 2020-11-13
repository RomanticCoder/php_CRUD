<?php
require_once('database.php');

$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if (empty($category_id)) {
    $category_id = 1;
}

$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
if (empty($price)) {
    $price = 0;
}

// Get products for selected category
// 1. use ""(double quote)
// 2. use ''(single quote) and cascading ex) 'categoryID =' . $category_id
// 3. use bind function :mycategory_id
$queryProducts = "SELECT * FROM products
WHERE categoryID = $category_id AND listPrice >= $price ORDER BY productID";
$statement = $db->prepare($queryProducts);
$statement->execute();
$products = $statement->fetchAll();
$statement->closeCursor();


// Get name for selected category
$queryCategory = "SELECT * FROM categories
                      WHERE categoryID = $category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$category_name = $category['categoryName'];
$statement1->closeCursor();

// Get all categories
$queryAllCategories = 'SELECT * FROM categories
                           ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();


?>


<!--                    HTML                    -->

<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="main.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<!-- the body section -->

<body>
    <main>
        <h1>Product list</h1>
        <aside>
            <form action="index.php" method="post" class="form">
                <h2>Categories</h2>
                <select class="form-control" id="categorySelect" name="category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['categoryID']; ?>" <?php if ($category_id == $category['categoryID']) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $category['categoryName']; ?></option>
                    <?php endforeach; ?>
                </select>
                <h2>Price</h2>
                <div class="form-group">
                    <label for="price">Minimum price: </label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
                </div>
                <input class="btn bg-success text-white" type="submit" value="go">
            </form>
        </aside>
    </main>
    <section>
        <h2><?php echo $category_name; ?></h2>
        <!-- product table -->
        <table class="table table-striped bg-white">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th class="right">Price</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product['productCode']; ?></td>
                    <td><?php echo $product['productName']; ?></td>
                    <td class="right"><?php echo $product['listPrice']; ?></td>
                </tr>
            <?php endforeach; ?>

        </table>
        <a class="btn btn-primary" a href="add_product_form.php" role="button">Add Product</a>
    </section>
    <footer>By GyeongEun Lee</footer>
</body>

</html>