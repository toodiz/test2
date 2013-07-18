<?php
$messages = array();
$campaign = new Controller\Campaign($pdo);




if (isset($_POST) && isset($_POST['update'])) {


    if (isset($_POST['name']) && $_POST['name'] == "")
        $messages['message'][] = "Le champ nom est obligatoire";

    if (isset($_POST['id']) && $_POST['id'] == "")
        $messages['message'][] = "Le champ id est obligatoire";

    if (empty($messages)) {
        $oneCampaign = $campaign->updateCampaign($_POST);
        $messages = array('success' => true, 'message' => array('La campagne a bien été modifié'));
    }
}

if ((isset($_GET['id']) && is_numeric($_GET['id']))) {

    //retrieve data campaign
    $id = $_GET['id'];
    $oneCampaign = $campaign->editCampaign($id);
    ?>

    <h2>Edition de la campagne ....<?php echo $oneCampaign->getName() ?></h2>

    <?php
    require ("_form.php");
    ?>
    <div class="separate"></div> 
    <?php
    require("../banner/list.php");
}
?>
