<!-- بسم الله الرحمن الرحيم -->

<?php

require_once "../PHP/CreateDB.php";

// Start Session to have the control of accessing the pages
session_start();

// An object
$db = new CreateDB("ShoppingCart", "products", "users");

// If the current user try to go to login page
if (isset($_SESSION['id']))
    header("Location: ../index.php");

$alerts = []; // Check Empty Fields
$errors = []; // Check The Validation of Fields

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

// Check Unique
function check_unique($table, $column, $input, $k, $m)
{
    global $errors;
    global $db;

    $q = "SELECT $column FROM $table WHERE $column = '$input'";
    $row = mysqli_query($db->con, $q);

    if (mysqli_num_rows($row) > 0)
        $errors[$k] = $m;
}

if (isset($_POST['register'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['pass']);

    // Check Empty Fields
    check_empty($name, 'name', 'name is required!!');
    check_empty($name, 'email', 'email is required!!');
    check_empty($name, 'pass', 'password is required!!');

    // Uniqueness
    if (!empty($_POST['email']) && !empty($_POST['pass'])) {
        check_unique('users', 'email', $email, 'email_unique', 'The email already exists, Try another email');
        check_unique('users', 'password', sha1($password), 'pass_unique', 'The password already exists, Try another password');
    }

    // Preg Match
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $errors['name'] = "only letters allowed";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_match'] = "invalid email format";
    }
    //Password must be 8 digits or more and include at least one numeric digit.
    if (!preg_match("/^(?=.*\d).{8,100}$/", $password)) {
        $errors['pass_match'] = "Password must be 8 digits or more and include at least one numeric digit";
    }

    // Check first that all things is OK
    if (empty($errors) && empty($alerts)) {
        // Make the name Capitalize before going to DB
        $name = strtolower($name);
        $name = ucwords($name);
        // Encrypt the password 
        $password = sha1($password);

        // Inserting Data into DB
        $query = "INSERT INTO users (name, email, password, is_admin) VALUES('$name', '$email', '$password', '0')";
        // Excute The Query
        mysqli_query($db->con, $query);
        // Direct To The login Page
        header("Location: login.php?status=success");
    }
}
?>


<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- CSS File -->
    <link rel="stylesheet" href="../style.css">

</head>

<body class="bg-dark">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo mb-5" id="shopping">
                    <h1><i class="fas fa-shopping-basket"></i> Shopping Cart</h1>
                </div>
                <div class="login-form">
                    <div>
                        <hr width="50%">
                        <h4 class="my-0"><strong class="card-title text-primary">Sign
                                Up</strong></h4>
                        <hr width="50%">
                    </div>
                    <form action="register.php" method="post">
                        <div class="form-group">
                            <label>User Name</label>
                            <div>
                                <input type="text" class="form-control" name="name" placeholder="User Name">
                                <?php if (isset($alerts['name'])) { ?>
                                <small class="form-text text-danger"><?php echo $alerts['name'] ?></small>
                                <?php } ?>
                                <?php if (isset($errors['name'])) { ?>
                                <small class="form-text text-danger"><?php echo $errors['name'] ?></small>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <div>
                                <input type="email" class="form-control" name="email" placeholder="Email">
                                <?php if (isset($alerts['email'])) { ?>
                                <small class="form-text text-danger"><?php echo $alerts['email'] ?></small>
                                <?php } ?>
                                <?php if (isset($errors['email_unique'])) { ?>
                                <small class="form-text text-danger"><?php echo $errors['email_unique'] ?></small>
                                <?php } ?>
                                <?php if (isset($errors['email_match'])) { ?>
                                <small class="form-text text-danger"><?php echo $errors['email_match'] ?></small>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div>
                                <input type="password" class="form-control" name="pass" placeholder="Password">
                                <?php if (isset($alerts['pass'])) { ?>
                                <small class="form-text text-danger"><?php echo $alerts['pass'] ?></small>
                                <?php } ?>
                                <?php if (isset($errors['pass_unique'])) { ?>
                                <small class="form-text text-danger"><?php echo $errors['pass_unique'] ?></small>
                                <?php } ?>
                                <?php if (isset($errors['pass_match'])) { ?>
                                <small class="form-text text-danger"><?php echo $errors['pass_match'] ?></small>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required> Agree the terms and policy
                            </label>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary my-2">Register</button>
                        <div class="register-link m-t-15 text-center">
                            <p>Already have account ? <a href="login.php"> Sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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