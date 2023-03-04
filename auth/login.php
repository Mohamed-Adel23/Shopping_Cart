<!-- بسم الله الرحمن الرحيم -->

<?php

// Start Session to have the control of accessing the pages
session_start();

// -- Authentication -- 
// If the current user try to go to login page
if (isset($_SESSION['user_id']))
    header("Location: ../index.php");
else if (isset($_SESSION['admin_id']))
    header("Location: ../admin/index.php");

require_once "../PHP/CreateDB.php";

// An object
$db = new CreateDB("ShoppingCart", "products", "users");

// To Show a message after being registered
$alerts = [];
if (isset($_POST)) {
    if (!empty($_GET))
        $alerts['succ'] = "Your Account is created succssfully!!";
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $password = sha1($password); // To comare with existing one in DB

    // Select data from DB
    $query = "SELECT * FROM users WHERE password = '$password' AND email = '$email'";
    // Excuting The Query
    $row = mysqli_query($db->con, $query);

    if (mysqli_num_rows($row) > 0) {
        $data = mysqli_fetch_assoc($row);

        // Check the user is admin or not
        if ($data['is_admin'] == '0') {
            // make the session equal to user id 
            $_SESSION['user_id'] = $data['id'];
            header("Location: ../index.php");
        } else {
            // make the session equal to admin id 
            $_SESSION['admin_id'] = $data['id'];
            header("Location: ../admin/index.php");
        }
    } else
        $alerts['failed'] = "Invalid Email or Password!!";
}


?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- CSS File -->
    <link rel="stylesheet" href="../style.css">

</head>

<body class="bg-dark">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <!-- Alert for the succss register -->
                <?php if (isset($alerts['succ'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulations!</strong> <?php echo $alerts['succ'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <div class="login-logo mb-5" id="shopping">
                    <h1><i class="fas fa-shopping-basket"></i> Shopping Cart</h1>
                </div>
                <div class="login-form">
                    <!-- Alert for the failed to login -->
                    <?php if (isset($alerts['failed'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Warning!</strong> <?php echo $alerts['failed'] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    <div>
                        <hr width="50%">
                        <h4 class="my-0"><strong class="card-title text-success">Sign
                                In</strong></h4>
                        <hr width="50%">
                    </div>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pass" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required> Agree the terms and policy
                            </label>
                        </div>
                        <button type="submit" name="login" class="btn btn-success my-2">Login</button>
                        <div class="register-link m-t-15 text-center">
                            <p>Create account ? <a href="register.php"> Sign up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

</html>

<!-- الحمد لله -->