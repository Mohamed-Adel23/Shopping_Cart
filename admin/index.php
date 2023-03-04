<!-- بسم الله الرحمن الرحيم -->

<?php

session_start();
// To be sure that user is already log in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) // Neither user nor admin
    header("Location: ../auth/login.php");
else if (isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) // User
    header("Location: ../index.php");


require_once "../PHP/CreateDB.php";
require_once "admin_component.php";

// Creating An Object of creating DB Class 
$db = new CreateDB("ShoppingCart", "products", "users");

$success = [];

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete')
        $success['deleted'] = 'The product is deleted successfully!!';
}

// Fetching the name of the user
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $query = "SELECT name FROM users WHERE id = $admin_id";
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
    <title>Products</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- CSS File -->
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: sticky; top: 0; z-index: 100;">
            <a href="index.php" class="navbar-brand">
                <h3 class="px-2" id="shopping">
                    <i class="fas fa-shopping-basket"></i> Shopping Cart <small id="admin">admin
                        panel</small>
                </h3>
            </a>
            <!-- <button class="navbar-toggler" type="button" data-toggl="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-lable="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="mr-auto"></div>
                <div class="navbar-nav">
                    <a href="add.php" class="nav-link active">
                        <h5 class="px-5 cart" id="addtext">
                            <i class="fas fa-plus" id="addicon"></i> Add Product
                        </h5>
                    </a>
                    <a href="../auth/logout.php" style="text-decoration: none;">
                        <h5 class="logout">
                            logout
                            <i class="fas fa-forward text-danger mt-2 mr-3 ml-1"></i>
                        </h5>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <!-- BootStrap Framework For FrontEnd -->
    <div class="container">
        <?php if (isset($success['deleted'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?php echo $success['deleted'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <!-- The name of the user -->
        <?php if (isset($_SESSION['admin_id'])) { ?>
            <div class="text-center mt-5 mb-0">
                <h3 id="user_name">
                    <strong>Welcome, </strong><?php echo $data['name'] ?>
                </h3>
            </div>
        <?php } ?>

        <!-- Make rows and make them in the center and have padding=>5 -->
        <div class="row text-center py-5">
            <?php
            // Invoke the method
            $data = $db->getData();

            // This Line means that you will get data from database until finish it, 
            // because this function return only one row so you will use while to get all data
            while ($row = mysqli_fetch_assoc($data))
                component($row['id'], $row['product_image'], $row['product_name'], $row['product_price'], $row['product_desc']);
            ?>
        </div>
    </div>

    <!-- The Footer -->
    <?php require_once "../PHP/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>

<!-- الحمد لله -->