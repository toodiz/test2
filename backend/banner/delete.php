<?php 
$messages = array();
if((isset($_GET['id']) && is_numeric($_GET['id'])) OR (isset($_POST['id']) && is_numeric($_POST['id']))){

$id = $_GET['id']; 
$banner = new Controller\Banner($pdo);   
$oneBanner = $banner->editBanner($id);

    
if(isset($_POST['id']) && $_POST['id']=="") 
    $messages['message'][] = "Le champ id est obligatoire";    
 

if(empty($messages) && isset($_POST['delete'])){
    $banner->deleteBanner($_POST);
    header('Location:'.ROOT.'/backend/campaign/index.php?action=edit&id='.$oneBanner->getCampaignId()); 
}
   
//retrieve data campaign

//var_dump($onebanner);
?>
<fieldset>
    <legend><h2>Suppression de la bannière  ?</h2></legend>
</fieldset>
<form action='index.php?action=delete&id=<?php echo $oneBanner->getId()?>' method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php if(isset($oneBanner)): echo $oneBanner->getId(); endif; ?>" />
 <?php if(isset($oneBanner) && $oneBanner->getImg()!=""): ?>
    <br /><img src="<?php echo ROOT ?>/web/uploads/<?php echo $oneBanner->getImg() ?>" width="350" />
    <?php endif; ?>
    <br /><br />
    <?php if(isset($oneBanner)): echo $oneBanner->getFilename(); endif; ?>
    
    <br /><br />
 <a href="<?php echo ROOT ?>/backend/campaign/index.php?action=edit&id=<?php echo $oneBanner->getCampaignId()?>" class="btn">&laquo; Retour</a><button onclick='if(!confirm("Souhaitez vous vraiment supprimer cette campagne?")) return false;' type="submit" name="delete" class="btn btn-danger"><span class='icon-trashcan'></span>  Supprimer</button>
</form>

<?php } ?>