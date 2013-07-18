<?php
$messages = array();
$_POST['img'] = "";
if (isset($_POST['add'])) {
    $banner = new Controller\Banner($pdo);

    if (isset($_FILES) && isset($_FILES['img']) && $_FILES['img']['name'] != "") {
        $result = $banner->uploadFile($_FILES['img']);

        if ($result['success']) {
            $_POST['img'] = $result['filename'];
        }
    }
    if (empty($messages)) {
        $oneBanner = $banner->addBanner($_POST);



        if (isset($oneBanner) && $oneBanner->getId())
            $messages = array('success' => true, 'message' => array('La bannière a bien été ajouté'));
    }
}
?>
<h2>Ajouter une bannière</h2>
<?php require ("_form.php"); ?>