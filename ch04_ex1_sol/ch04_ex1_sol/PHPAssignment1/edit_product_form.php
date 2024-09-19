<?php
// Include the database connection
require_once('database.php');

// Get the product ID from the POST data
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

// Fetch product details from the database
$queryProduct = 'SELECT * FROM products WHERE productID = :product_id';
$statement = $db->prepare($queryProduct);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$product = $statement->fetch();
$statement->closeCursor();

// Fetch all categories for the dropdown list
$queryCategories = 'SELECT * FROM categories ORDER BY categoryID';
$statement2 = $db->prepare($queryCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
<header><h1>Product Manager</h1></header>
<main>
    <h1>Edit Product</h1>
    <form action="update_item.php" method="post" id="add_product_form">
    <label>Poduct ID:</label>
        <input name="product_id" value="<?php echo $product['productID'] ?>"readonly><br>

        <label>Category:</label>
        <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>"
                    <?php if ($category['categoryID'] == $product['categoryID']) 
                    echo 'selected'; ?>>
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Code:</label>
        <input type="text" name="code" value="<?php echo htmlspecialchars($product['productCode']); ?>"><br>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['productName']); ?>"><br>

        <label>List Price:</label>
        <input type="text" name="price" value="<?php echo htmlspecialchars($product['listPrice']); ?>"><br>

        <label>&nbsp;</label>
        <input type="submit" value="Save Changes"><br>
    </form>
    <p><a href="index.php">View Product List</a></p>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
</footer>
</body>
</html>
