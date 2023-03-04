<!-- بسم الله الرحمن الرحيم -->

<!-- 
    Project: Shopping Cart
    Date: 18-2-2023
    Day: First

    Date: 20-2-2023
    Day: Second

    Date: 21-2-2023
    Day: Third

    Date: 22-2-2023
    Day: Fourth

    Date: 23-2-2023
    Day: Fifth

    Date: 24-2-2023
    Day: Sixth

    Date: 27-2-2023
    Day: Seventh

    Date: 28-2-2023
    Day: Eighth

    Date: 1-3-2023
    Day: Ninth

    Date: 2-3-2023
    Day: Tenth

    Date: 3-3-2023
    Day: Eleventh
 -->

<?php

// Make a Session to link with adding to cart 
session_start();

// To be sure that user is already log in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) // Either user nor admin
    header("Location: auth/login.php");
else if (!isset($_SESSION['user_id']) && isset($_SESSION['admin_id'])) // Admin
    header("Location: admin/index.php");

require_once "PHP/CreateDB.php";
require_once "PHP/component.php";

$success = [];
// Check if the user add a product or not
if (isset($_POST['add'])) {

    if (isset($_SESSION['cart'])) {
        // Get the ids only from the 2D Array
        $ids = array_column($_SESSION['cart'], "product_id");

        // Check if the product is already added or not
        if (in_array($_POST['product_id'], $ids)) {
            // A message to say to user that he chose this product before (JS)
            echo "<script>alert('Product is already added to the cart!!')</script>";
            echo "<script>window.location = 'index.php'</script>";
        } else {
            // Add the product to the cart
            $count = count($ids); // To store the id in the next index
            $arr_item = ["product_id" => $_POST['product_id'], "num_of_items" => 1];
            $_SESSION['cart'][$count] = $arr_item;
            $success['add'] = "The product is added";
        }
    } else { // This will be excuted only once in the begining
        // To store the id in an associative way
        $arr_item = ["product_id" => $_POST['product_id'], "num_of_items" => 1];
        $_SESSION['cart'][0] = $arr_item;
        $success['add'] = "The product has been added successfully";
    }
}

// Creating An Object of creating DB Class 
$db = new CreateDB("ShoppingCart", "products", "users");

// Fetching the name of the user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT name FROM users WHERE id = $user_id";
    $row = mysqli_query($db->con, $query);
    $data = mysqli_fetch_assoc($row);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- <nav class="navbar bg-body-tertiary" style="background-color: black; position: sticky; top: 0; z-index: 100;">
        <div class="container-fluid">
            <a class="navbar-brand" style="color: white">Shopping Cart</a>
            <form action="index.php" method="post" class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav> -->

    <?php require_once "PHP/header.php" ?>
    <!-- BootStrap Framework For FrontEnd -->
    <div class="container">
        <?php if (isset($success['add'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?php echo $success['add'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <!-- The name of the user -->
        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="text-center mt-5 mb-0">
                <h3 id="user_name">
                    <strong>Welcome, </strong><?php echo $data['name'] ?>
                </h3>
            </div>
        <?php } ?>
        <!-- Make rows and make them in the center and have padding=>5 -->
        <div class="row text-center py-5">
            <!-- We will Create Four Shopping Cart Items -->
            <!-- So we will use here the bootstrap grid system and bootstrap has 12 column grid system -->
            <!-- We use 3 column space and 6 for small devices and have margin 3 -->
            <!-- And Finally This Div will take 3 column space of grid -->
            <?php
            // Invoke the method
            $data = $db->getData();
            // $rows = mysqli_fetch_assoc($data);
            // echo '<pre>';
            // var_dump($data);
            // echo '</pre>';
            // die();

            // This Line means that you will get data from database until finish it, 
            // because this function return only one row so you will use while to get all data
            while ($row = mysqli_fetch_assoc($data))
                component($row['id'], $row['product_image'], $row['product_name'], $row['product_price'], $row['product_desc']);
            ?>
        </div>
    </div>

    <!-- The Footer -->
    <?php require_once "PHP/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
<!-- الحمد لله -->