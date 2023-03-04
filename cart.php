<!-- بسم الله الرحمن الرحيم -->

<?php

// Make a Session to link with adding to cart 
session_start();

// To be sure that user is already log in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) // Either user nor admin
    header("Location: auth/login.php");
else if (!isset($_SESSION['user_id']) && isset($_SESSION['admin_id'])) // Admin
    header("Location: admin/index.php");

require_once "PHP/component.php";
require_once "PHP/CreateDB.php";

// An Object 
$db = new CreateDB("ShoppingCart", "products", "users");

// Array for make an alert to the user
$success = [];
// Delete an item from the cart 
if (isset($_POST['remove'])) {
    // The (Key) here is the indecies of the array and (value) consists of key & value
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_id'] == $_GET['id']) {
            unset($_SESSION['cart'][$key]); // remove the product from session without remove it from DB
            $success['remove'] = "The Product has been removed";
        }
    }
}

// The Plus operator to increase the number of items
if (isset($_POST['plus'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_id'] == $_GET['id']) {
            $_SESSION['cart'][$key]["num_of_items"] += 1;
            break;
        }
    }
    // The Minus operator to increase the number of items
} else if (isset($_POST['minus'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_id'] == $_GET['id']) {
            if ($_SESSION['cart'][$key]["num_of_items"] > 1) {
                $_SESSION['cart'][$key]["num_of_items"] -= 1;
                break;
            } else {
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">

</head>

<body class="bg-light">

    <!-- Invoke The header file -->
    <?php require_once "PHP/header.php" ?>

    <div class="container-fluid">
        <!-- Padding to the left and right side -->
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart">
                    <h6 class="text-primary">MY CART</h6>
                    <hr>

                    <!-- Alert for the removed product -->
                    <?php if (isset($success['remove'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?php echo $success['remove'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } ?>

                    <!-- The Chosen Products -->
                    <?php
                    $total_price = 0;
                    $total_discounted_price = 0;
                    // Always check before you go
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $ids) {
                            $id = $ids['product_id'];
                            // Query to get the data from DB
                            $query = "SELECT * FROM products WHERE id = $id";
                            $data = mysqli_query($db->con, $query);
                            // Fetch one row
                            $row = mysqli_fetch_assoc($data);

                            // Putting the chosen products on the page and invoke this function from component file
                            products($row['id'], $row['product_image'], $row['product_name'], $row['product_price'], $row['product_desc'], $ids['num_of_items']);

                            // Calculate The Total price 
                            $price = $row['product_price'] * $ids['num_of_items'];
                            $total_price += $price + 0.99;
                            $total_discounted_price += ($price - $price * 0.2 + 0.99);
                        }
                    } else {
                        $element = "
                            <div class=\"container-fluid mt-100\">
                                <div class=\"row\">
                                    <div class=\"col-md-12\">
                                        <div class=\"card-body cart\">
                                            <div class=\"col-sm-12 empty-cart-cls text-center\">
                                                <img src=\"https://i.imgur.com/dCdflKN.png\" width=\"130\" height=\"130\" class=\"img-fluid mb-4 mr-3\">
                                                <h4>Your Cart is Empty!</h4>
                                                <small class=\"text-muted\">Add something to make me happy :)</small><br>
                                                <a href=\"index.php\" class=\"btn btn-success cart-btn-transform m-3\" data-abc=\"true\">Start Shopping</a>                                            
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                        ";
                        echo $element;
                        exit;
                    }
                    ?>
                </div>
            </div>
            <!-- Calculate The items and its prices -->
            <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
                <div class="pt-4">
                    <h6 align="center" class="text-info">PRICE DETAILS</h6>
                    <hr>
                    <div class="row price-details">
                        <!-- 6 columns -->
                        <div class="col-md-6">
                            <?php
                            $count = 0;
                            if (isset($_SESSION['cart'])) {
                                $ids = array_column($_SESSION['cart'], "num_of_items");
                                $count = array_sum($ids);
                                echo "<h6> Total Items is <span class=\"text-success\"><b>($count)</b></span> </h6>";
                            } else {
                                echo "<h6> Total Items is <span class=\"text-success\"><b>($count)</b></span></h6>";
                            }
                            ?>
                            <h6>Delivery Charges</h6>
                            <hr>
                            <h6>Amount Payable</h6>
                        </div>
                        <!-- 6 columns -->
                        <div class="col-md-6">
                            <h6> $<?php
                                    $_SESSION['price'] = $total_discounted_price; // To show it in the checkout page
                                    echo $total_discounted_price ?>
                                <small><s class="text-secondary text-danger">$<?php echo $total_price ?></s></small>
                            </h6>
                            <h6 class="text-success">FREE</h6>
                            <hr>
                            <h6 style="font-size: 19px;">
                                $<?php echo $total_discounted_price ?>
                            </h6>
                        </div>
                    </div>
                </div>
                <div align="center">
                    <a href="checkout.php" class="btn btn-outline-info cart-btn-transform m-3 w-50"
                        data-abc="true"><span style="font-size: 18px;">CheckOut</span></a>
                </div>
            </div>
        </div>
    </div>

    <!-- The Footer -->
    <?php require_once "PHP/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>

<!-- الحمد لله -->