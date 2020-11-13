<?php
require_once('database.php');

// Get category ID
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if ($category_id == NULL || $category_id == FALSE) {
    $category_id = 1;
}

//get price
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
if ($price == NULL || $price == FALSE) {
    $price = 1;
}

// Get name for selected category
$queryCategory = 'SELECT * FROM categories
                      WHERE categoryID = :category_id';
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

// Get products for selected category
$queryProducts = 'SELECT * FROM products
              WHERE categoryID = :category_id
              AND listPrice >= :price
              ORDER BY productID';
$statement3 = $db->prepare($queryProducts);
$statement3->bindValue(':category_id', $category_id);
$statement3->bindValue(':price', $price);
$statement3->execute();
$products = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<!-- the body section -->

<body>
    <main>
        <h1>Product List</h1>
        <aside>
            <!-- display a list of categories -->

            <form action="index.php" method="post">
                <h2>Categories</h2>
                <select class="form-control" id="categorySelect" name="category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['categoryID']; ?>" <?php if ($category_id == $category['categoryID']) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $category['categoryName']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <div class="form-group">
                    <label for="price">Minimum Price:</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
                </div>
                <input class="btn bg-success text-white" type="submit" value="go">
            </form>

        </aside>

        <section>
            <!-- display a table of products -->
            <h2><?php echo $category_name; ?></h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th class="right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo $product['productCode']; ?></td>
                            <td><?php echo $product['productName']; ?></td>
                            <td class="right"><?php echo $product['listPrice']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer></footer>
</body>

</html>