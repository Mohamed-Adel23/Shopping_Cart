<!-- بسم الله الرحمن الرحيم -->

<?php
require_once "../PHP/CreateDB.php";

// Creating an object
$db = new CreateDB("ShoppingCart", "products", "users");

$id = $_GET['id'];

// Delete The old image before updating
$query = "SELECT product_image FROM products WHERE id = $id";
$data = mysqli_query($db->con, $query);
$element = mysqli_fetch_assoc($data);
$image = $element['product_image'];
// Delete the image
unlink("../Uploads/$image");

// Delete The Product from Dabase
$query = "DELETE FROM products WHERE id = $id";
mysqli_query($db->con, $query);

header("Location: index.php?action=delete");

?>
<!-- الحمد لله -->