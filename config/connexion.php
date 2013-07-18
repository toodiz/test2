<?php 
require('config.php');
//require('../../autoload.php');
try {
    $dns = 'mysql:host='.HOST.';dbname='.DBNAME;  
    $pdo = new PDO( $dns, USERNAME, PASSWORD );   
    
} catch ( Exception $e ) {
    echo "<pre>";
    print_r($e);
    echo "</pre>";
    
  echo "Connection à MySQL impossible : ", $e->getMessage();
  die();
}



?> 