<?php

ini_set('display_errors', true);
require('../../config/header.php');
require('../../config/connexion.php');


//ob_start();
if(isset($_GET['action']) && $_GET['action']!=""){
    
            $action = $_GET['action'].".php"; 
            if(file_exists($action)){
                include($action);     
            }
}else{
    
    require('list.php');
    
}
//$content = ob_get_contents();
//ob_end_clean();    
?>
<div class="container">
<?php
echo $content;
?>
</div>
<?php
require('../../config/footer.php');
?>








