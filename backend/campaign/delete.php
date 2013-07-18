<?php 
$messages = array();
if((isset($_GET['id']) && is_numeric($_GET['id'])) OR (isset($_POST['id']) && is_numeric($_POST['id']))){


$id = $_GET['id'];  
$campaign = new Controller\Campaign($pdo);  
//retrieve data campaign
$oneCampaign = $campaign->editCampaign($id);  

if(isset($_POST['id']) && $_POST['id']=="") 
    $messages['message'][] = "Le champ id est obligatoire";    
 

if(empty($messages) && isset($_POST['delete'])){
    $oneCampaign = $campaign->deleteCampaign($_POST);
    header('Location: index.php'); 
}
   

//var_dump($onebanner);
?>
<fieldset>
    <legend><h2>Suppression de la campagne ....<?php echo $oneCampaign->getName() ?> ?</h2></legend>
</fieldset>
<form action='index.php?action=delete&id=<?php echo $oneCampaign->getId()?>' method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php if(isset($oneCampaign)): echo $oneCampaign->getId(); endif; ?>" />
<?php if(isset($oneCampaign)): echo $oneCampaign->getName(); endif; ?>
    <br /><br />
    <?php if(isset($oneCampaign)): echo $oneCampaign->getDescription(); endif; ?>
    
    <br /><br />
 <a href="index.php" class="btn">&laquo; Retour</a><button onclick='if(!confirm("Souhaitez vous vraiment supprimer cette campagne?")) return false;' type="submit" name="delete" class="btn btn-danger"><span class='icon-trashcan'></span>  Supprimer</button>
</form>

<?php } ?>