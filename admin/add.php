<!-- بسم الله الرحمن الرحيم -->


<?php

session_start();
// To be sure that user is already log in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) // Neither user nor admin
    header("Location: ../auth/login.php");
else if (isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) // User
    header("Location: ../index.php");


require_once "../PHP/CreateDB.php";

// Creating an object
$db = new CreateDB("ShoppingCart", "products", "users");

$alerts = []; // Check Empty Fields

// Validation Functions.
function validate($input)
{
    $input = trim($input); // delete all spaces before and after the text
    $input = htmlspecialchars($input); // ignore all html chars
    $input = stripcslashes($input); // remove slashes
    return $input;
}

// Check Empty
function check_empty($input, $k, $m)
{
    global $alerts;
    if (empty($input))
        $alerts[$k] = $m;
}

if (isset($_POST['add'])) {
    $name = validate($_POST['name']);
    $price = validate($_POST['price']);
    $desc = validate($_POST['description']);

    // Check The Empty of fields
    check_empty($name, 'name', 'The Name is required');
    check_empty($price, 'price', 'The price is required');
    check_empty($desc, 'desc', 'The description is required');

    // Images
    $code = rand(1, 100);
    $image_name = $_FILES['image']['name'];
    $image_name = $code . '-' . $image_name;
    $tmp_name = $_FILES['image']['tmp_name'];
    $path = "../Uploads/$image_name";

    $allowed_ext = ['png', 'jpg', 'jpeg']; // To Check if the file is an image or not
    $str_to_arr = explode('.', $image_name); // To separate the file name
    $ext = end($str_to_arr); // png
    if (!in_array($ext, $allowed_ext))
        $alerts['image'] = "Not Allowed Extension...";

    if (empty($alerts)) {
        // Putting images in the right place
        move_uploaded_file($tmp_name, $path);

        // Inserting the data
        $query = "INSERT INTO products (product_name, product_price, product_image, product_desc) VALUES('$name', '$price', '$image_name', '$desc')";
        mysqli_query($db->con, $query); // Excuting the query

        $alerts['added'] = 'Product Added Succefully!!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CSS File -->
    <link rel="stylesheet" href="../style.css">
</head>

<body style="max-width: 1521px;">

    <!-- header -->
    <?php require_once "admin_header.php" ?>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 mt-5">

                    <!-- Alert for the added product -->
                    <?php if (isset($alerts['added'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo $alerts['added'] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <div class="card">
                        <div class="card-header">
                            <strong>Add New <span class="text-success">Product</span></strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3 mt-2"><label for="name" class="form-control-label">Product
                                            name</label></div>
                                    <div class="col-12 col-md-9 mt-2"><input type="text" id="name" name="name" placeholder="name" class="form-control">
                                        <?php if (isset($alerts['name'])) { ?>
                                            <small class="form-text text-danger"><?php echo $alerts['name'] ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3 mt-2"><label for="price" class=" form-control-label">Product
                                            price</label></div>
                                    <div class="col-12 col-md-9 mt-2"><input type="number" id="price" name="price" placeholder="price" class="form-control">
                                        <?php if (isset($alerts['price'])) { ?>
                                            <small class="form-text text-danger"><?php echo $alerts['price'] ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3 mt-2"><label for="description" class=" form-control-label">Description</label></div>
                                    <div class="col-12 col-md-9 mt-2"><textarea name="description" id="description" rows="5" placeholder="description..." class="form-control"></textarea>
                                        <?php if (isset($alerts['desc'])) { ?>
                                            <small class="form-text text-danger"><?php echo $alerts['desc'] ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3 mt-2"><label class=" form-control-label">Product
                                            image</label>
                                    </div>
                                    <div class="col-12 col-md-9 mt-2"><input type="file" name="image">
                                        <?php if (isset($alerts['image'])) { ?>
                                            <small class="form-text text-danger"><?php echo $alerts['image'] ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div align="center" class="mt-5">
                                    <button type="submit" class="btn btn-outline-primary btn-sm" name="add">
                                        <i class="fa fa-plus"></i> Add
                                    </button>
                                    <button type="reset" class="btn btn-outline-danger btn-sm ml-5">
                                        <i class="fa fa-ban"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
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