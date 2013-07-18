<?php
$messages = array();

if (isset($_POST) && isset($_POST['add'])) {
    
  
    $campaign = new Controller\Campaign($pdo);

    if (isset($_POST['name']) && $_POST['name'] == "")
        $messages['message'] = array("Le champ nom est obligatoire");

    if (empty($messages)) {   
        $oneCampaign = $campaign->addCampaign($_POST);
        
        if (isset($oneCampaign) && $oneCampaign->getId())
            $messages = array('success'=>true,'message'=>array('La campagne a bien été ajouté'));
    }
}
?>
<h2>Ajouter une campagne</h2>
<?php require ("_form.php"); ?>
