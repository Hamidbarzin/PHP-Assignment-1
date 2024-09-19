<?php
	$product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_STRING);
	$list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);
	$discount_percent = filter_input(INPUT_POST, 'discount_percent'. FILTER_VALIDATE_FLOAT);

    $error_message = '';
    if ($list_price === false || $list_price <= 0) {
        $error_message = "Please enter a valid list price.";
    } else if ($discount_percent === false || $discount_percent < 0 || $discount_percent >100) {
        $error_message = "Please enter a value between 0% and 100%."
    } 
	
        $discount = $list_price * $discount_percent * .01;
        $discount_price = $list_price - $discount;
        $sales_tax_rate = 0.08;
        $sales_tax = $discounted_price * $sales_tax_rate;
        $sales_total = $discounted_price + $sales_tax;
        
        $list_price_f = "$".number_format($list_price, 2);
        $discount_percent_f = $discount_percent."%";
        $discount_f = "$".number_format($discount, 2);
        $discount_price_f = "$".number_format($discount_price, 2);
        $sales_tax_f = "$".number_format($sales_tax, 2);
        $sales_total_f = "$".number_format($sales_total, 2);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Product Discount Calculator</h1>

        <label>Product Description:</label>
        <span><?php echo htmlspecialchars($product_description); ?></span><br>

        <label>List Price:</label>
        <span><?php echo $list_price_f; ?></span><br>

        <label>Discount Percent:</label>
        <span><?php echo $discount_percent_f; ?></span><br>

        <label>Discount Amount:</label>
        <span><?php echo $discount_f; ?></span><br>

        <label>Discount Price:</label>
        <span><?php echo $discount_price_f; ?></span><br>

        <label>Sales Tax Rate:</label>
        <span>8%</span>

        <label>Sales Tax Amount:</label>
        <span><?php echo $sales_tax_f; ?></span><br>

        <label>Total Price (including tax):</label>
        <span><?php echo $sales_total_f; ?></span><br>        
    </main>
</body>
</html>