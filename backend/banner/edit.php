<?php
$messages = array();
$_POST['img'] = "";
$banner = new Controller\Banner($pdo);
if (isset($_POST['update'])) {


   

    
     if (isset($_FILES) && isset($_FILES['img']) && $_FILES['img']['name'] != "") {
        $result = $banner->uploadFile($_FILES['img']);

        if ($result['success']) {
            $_POST['img'] = $result['filename'];
        }
    }


    
    if (empty($messages)) {
        $oneCampaign = $banner->updateBanner($_POST);
        $messages = array('success' => true, 'message' => array('La campagne a bien été modifié'));
    }
}

if ((isset($_GET['id']) && is_numeric($_GET['id']))) {

    //retrieve data campaign
    $id = $_GET['id'];
    $oneBanner = $banner->editBanner($id);
    
    ?>
<h2>Edition ....</h2>
    <?php
    require ("_form.php");
}
?>
