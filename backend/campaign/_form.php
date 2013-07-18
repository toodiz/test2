<?php 

if(isset($oneCampaign) && $_GET['action']=='edit'): 
    $formArray = array(
        'formAction'=> ROOT.'/backend/campaign/index.php?action=edit&id='.$oneCampaign->getId(),

        'submitLabel'=>'<span class="icon-pencil"></span>  Modifier',
        'submitName'=>'update',
        'classBtn'=>'btn-info'
        );   
else:
    $formArray = array(
        'formAction'=>'index.php?action=add',
        'submitLabel'=>'<span class="icon-plus"></span>  Ajouter',
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
    <label>Name</label>
    <input type="hidden" name="id" value="<?php if(isset($oneCampaign)): echo $oneCampaign->getId(); endif; ?>" />
    <input type="text" class="input-xxlarge" name="name" placeholder="Nom de la campagne" value="<?php if(isset($oneCampaign)): echo $oneCampaign->getName(); endif; ?>">
    <label>Description</label>
    <textarea placeholder="Description de la campagne" rows="8" cols="8" name="description"><?php if(isset($oneCampaign)): echo $oneCampaign->getDescription(); endif; ?></textarea>
    <!--<span class="help-block">Example block-level help text here.</span>-->
    <label class="checkbox">
      <input type="checkbox" <?php if(isset($oneCampaign) && $oneCampaign->getIsActivated()):?> checked <?php endif;?> name="is_activated" value="1"> is activated ?
    </label>
    <a href="index.php" class="btn">&laquo; Retour</a><button type="submit" name="<?php echo $formArray['submitName']; ?>" class="btn <?php echo $formArray['classBtn'] ?>"><?php echo $formArray['submitLabel'] ?></button>
</form>