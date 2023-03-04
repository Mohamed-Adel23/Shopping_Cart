<!-- بسم الله الرحمن الرحيم -->


<?php

class CreateDB
{
    // Attributes for the connection to DB
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename1;
    public $tablename2;
    public $con;

    // The Constructor
    // Creating The DAtabase and table of products
    public function __construct(
        $dbname = "ShoppingCart",
        $tablename1 = "products",
        $tablename2 = "users",
        $servername = "localhost",
        $username = "root",
        $password = ""
    ) {
        $this->dbname = $dbname;
        $this->tablename1 = $tablename1;
        $this->tablename2 = $tablename2;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;

        try {

            // The Connection To DB
            $this->con = mysqli_connect($servername, $username, $password);

            // Creating The DB
            $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
            // Check if the query is excuted or not
            if (!mysqli_query($this->con, $sql)) {
                echo "Oops ERROR in Creating the Database " . mysqli_connect_error();
                exit;
            }

            // Connect To my Database
            $this->con = mysqli_connect($servername, $username, $password, $dbname);

            // Create The Table of products
            $sql = "CREATE TABLE IF NOT EXISTS $tablename1 (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(25) NOT NULL,
                product_price FLOAT,
                product_image VARCHAR(100),
                product_desc VARCHAR(255)
                );";

            // Check if the query is excuted or not
            if (!mysqli_query($this->con, $sql)) {
                echo "Oops ERROR in Creating the table " . mysqli_error($this->con);
                exit;
            }

            // Create The Table of Users
            $sql = "CREATE TABLE IF NOT EXISTS $tablename2 (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(25) NOT NULL,
                email VARCHAR(100) NOT NULL,
                password CHAR(50) NOT NULL,
                is_admin ENUM('1','0') NOT NULL
                );";

            // Check if the query is excuted or not
            if (!mysqli_query($this->con, $sql)) {
                echo "Oops ERROR in Creating the table " . mysqli_error($this->con);
                exit;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            echo '<h3 align="center">' . $error . '</h3>';
            exit;
        }
    }

    // Method To get The Data From The Database
    public function getData()
    {
        $sql = "SELECT * FROM products";
        $result = mysqli_query($this->con, $sql);

        if (mysqli_num_rows($result) > 0)
            return $result;
    }
}


?>

<!-- الحمد لله -->