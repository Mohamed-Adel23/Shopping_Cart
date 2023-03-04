<!-- بسم الله الرحمن الرحيم -->

<?php


// To Show The Provided products 
function component($product_id, $product_image, $product_name, $product_price, $product_description = "Good Product")
{
    // Discount On The Price
    $price_after_discount = $product_price - 0.2 * $product_price;
    $product_price += 0.99;
    $price_after_discount += 0.99;

    // The Code of Product Cart
    $element = "
            <!-- We will Create Four Shopping Cart Items -->
            <!-- So we will use here the bootstrap grid system and bootstrap has 12 column grid system -->
            <!-- We use 3 column space and 6 for small devices and have margin 3 -->
            <!-- And Finally This Div will take 3 column space of grid -->
            <link rel=\"stylesheet\" href=\"../style.css\">
            <div class=\"col-md-3 col-sm-6 my-3 my-md-100\">
                <form action=\"update.php?id=$product_id\" method=\"post\">
                    <div class=\"card shadow\">
                        <div>
                            <img src=\"../Uploads/$product_image\" alt=\"$product_name\" class=\"img-fluid card-img-top\">
                        </div>
                        <div class=\"card-bod\">
                            <h5 class=\"card-title\">$product_name</h5>
                            <h6>
                                <!-- fas=> 1star / far=> empty star -->
                                <i class=\"fas fa-star\"></i>
                                <i class=\"fas fa-star\"></i>
                                <i class=\"fas fa-star\"></i>
                                <i class=\"fas fa-star-half\"></i>
                                <i class=\"far fa-star\"></i>
                            </h6>
                            <p class=\"card-text px-1\">
                                $product_description
                            </p>
                            <h5>
                                <span>$$price_after_discount</span>
                                <small><s class=\"text-secondary\">$$product_price</s></small>
                            </h5>
                            <!-- Make a beautiful button and through it I can know if the user press on the button or not -->
                            <button type=\"submit\" class=\"btn btn-outline-secondary my-3 py-1\">Edit <i class=\"fas fa-pen\"></i></button>
                            <a href=\"delete.php?id=$product_id\" class=\"btn btn-outline-danger my-3 py-1\">Remove <i class=\"fas fa-trash\"></i></a>
                        </div>
                    </div>
                </form>
            </div>
    ";

    echo $element;
}

?>

<!-- الحمد لله -->