<?php
define('DB_DATABASE','adress');
define('DB_USERNAME','root');
define('DB_PASSWORD','root');
define('PDO_DSN','mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

function connect() {
try {
    $dbconnect= new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $dbconnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbconnect;
} catch(PDOException $e) {
    echo 'Error' .$e->getMessage();
    die();
}
}

?>
