<!-- بسم الله الرحمن الرحيم -->

<?php

// Make a Session to link with adding to cart 
session_start();

// To be sure that user is already log in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) // Neither user nor admin
    header("Location: auth/login.php");
else if (!isset($_SESSION['user_id']) && isset($_SESSION['admin_id'])) // Admin
    header("Location: admin/index.php");

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
// die();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckOut</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">



</head>

<body style="max-width: 1503px;">
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: sticky; top: 0; z-index: 100;">
            <a href="cart.php" class="navbar-brand">
                <h4 class="px-2" id="cart">
                    <i class="fa fa-backward text-danger mt-2 mr-3 ml-1"></i> Back to My Cart
                </h4>
            </a>
            <button class="navbar-toggler" type="button" data-toggl="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-lable="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </header>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title" id="payment">Payment</strong>
                </div>
                <div class="card-body">
                    <!-- Credit Card -->
                    <div id="pay-invoice">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center" id="pay">Pay Invoice</h3>
                            </div>
                            <hr>
                            <form action="checkout.php" method="post" novalidate="novalidate">
                                <div class="form-group text-center">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><i class="text-muted fa fa-cc-visa fa-2x"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-cc-mastercard fa-2x"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-cc-amex fa-2x"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-cc-discover fa-2x"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-cc-paypal fa-2x"></i></li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="cc-payment" class="control-label mb-1">Payment amount</label>
                                    <input id="cc-payment" name="cc-payment" type="text" class="form-control" aria-required="true" aria-invalid="false" value="$<?php echo $_SESSION['price'] ?>" disabled>
                                </div>
                                <div class="form-group has-success">
                                    <label for="cc-name" class="control-label mb-1">Name on card</label>
                                    <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name">
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                </div>
                                <div class="form-group">
                                    <label for="cc-number" class="control-label mb-1">Card number</label>
                                    <input id="cc-number" name="cc-number" type="tel" class="form-control cc-number identified visa" value="" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number">
                                    <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label mb-1">Expiration</label>
                                            <input id="cc-exp" name="cc-exp" type="tel" class="form-control cc-exp" value="" data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="MM / YY">
                                            <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="x_card_code" class="control-label mb-1">Security code</label>
                                        <div class="input-group">
                                            <input id="x_card_code" name="x_card_code" type="tel" class="form-control cc-cvc" value="" data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" autocomplete="off">
                                            <div class="input-group-addon">
                                                <span class="fa fa-question-circle fa-lg" data-toggle="popover" data-container="body" data-html="true" data-title="Security Code" data-content="<div class='text-center one-card'>The 3 digit code on back of the card..<div class='visa-mc-cvc-preview'></div></div>" data-trigger="hover"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-lock fa-lg"></i>&nbsp;
                                        <span id="payment-button-amount">Pay
                                            $<?php echo $_SESSION['price'] ?></span>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- .card -->
        </div>
        <div class="col-lg-3"></div>
    </div>


    <!-- The Footer -->
    <?php require_once "PHP/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
</body>

</html>

<!-- الحمد لله -->