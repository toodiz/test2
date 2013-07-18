<?php 


 if(isset($oneBanner)):
     $campaign_id = $oneBanner->getCampaignId();
 elseif(isset($_GET['campaign_id']) && is_numeric($_GET['campaign_id'])):
    $campaign_id = $_GET['campaign_id'];
 endif;




if(isset($oneBanner) && $_GET['action']=='edit'): 
    $formArray = array(
        'formAction'=> ROOT.'/backend/banner/index.php?action=edit&id='.$oneBanner->getId(),
        'submitLabel'=>'<span class="icon-pencil"></span> Modifier',
        'submitName'=>'update',
        'classBtn'=>'btn-info'
        );   
else:
    $formArray = array(
        'formAction'=>ROOT.'/backend/banner/index.php?action=add',
        'submitLabel'=>'<span class="icon-plus"></span> Ajouter',
        'submitName'=>'add',
        'classBtn'=>'btn-info'
        );
endif;
?>

<?php 
if(count($messages)>0): ?>
<ul <?php if(isset($messages['success']) && $messages['success']): echo 'class="alert alert-success"'; else: echo 'class="alert alert-error"'; endif; ?>>
    <?php foreach($messages['message'] as $message): ?>
        <li><?php echo $message; ?></li>
    <?php endforeach; ?>
</ul>
 <?php   
endif;
?>
<form action="<?php echo $formArray['formAction']; ?>" method="POST" enctype="multipart/form-data">
    <label>Choisissez une image</label>
    <input type="hidden" name="id" value="<?php if(isset($oneBanner)): echo $oneBanner->getId(); endif; ?>" />
    <input type="hidden" name="campaign_id" value="<?php if(isset($campaign_id)): echo $campaign_id; endif; ?>" />
    <input type="file" class="input-xxlarge" name="img" placeholder="Nom de la campagne" />
    
    <?php if(isset($oneBanner) && $oneBanner->getImg()!=""): ?>
    <br /><img src="<?php echo ROOT ?>/web/uploads/<?php echo $oneBanner->getImg() ?>" width="350" />
    <?php endif; ?>
    
    <label>Saisissez le nom du fichier qui sera inclus dans la popin</label>
    <input type="text" class="input-xxlarge" name="filename" value="<?php if(isset($oneBanner)): echo $oneBanner->getFilename(); endif; ?>" placeholder="Nom du fichier" >
    <!--<span class="help-block">Example block-level help text here.</span>-->
    <label class="checkbox">
      <input type="checkbox" <?php if(isset($oneBanner) && $oneBanner->getIsActivated()):?> checked <?php endif;?> name="is_activated" value="1"> is activated ?
    </label>
    <a href="<?php echo ROOT ?>/backend/campaign/index.php?action=edit&id=<?php echo $campaign_id ?>" class="btn">&laquo; Retour</a><button type="submit" name="<?php echo $formArray['submitName']; ?>" class="btn <?php echo $formArray['classBtn'] ?>"><?php echo $formArray['submitLabel'] ?></button>
</form>