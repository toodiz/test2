<?php
$banner = new Controller\Banner($pdo);
$listBanners = $banner->listByCampaignId($id);
?>
<h2>Liste des bannières de cette campagne</h2>
<a class="btn btn-info" href='<?php echo ROOT ?>/backend/banner/index.php?action=add&campaign_id=<?php echo $id ?>'><span class='icon-plus'></span>  Créer une bannière</a>
<br /><br /><table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>id</th>
            <th>img</th>
             <th>filename</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th></th>
            <th></th>
        </tr>
    <tbody>
        <?php
        foreach ($listBanners as $banner) {
            
            echo "<tr ".(($banner->getIsActivated()==0)?'class=\'error\'':'').">
                <td>" . $banner->getId() . "</td>
                <td>" . $banner->getImg() . "</td>
                <td>" . $banner->getFilename() . "</td>
                <td>" . $banner->getCreatedAt() . "</td>
                <td>" . $banner->getUpdatedAt() . "</td>
                <td><a href='".ROOT."/backend/banner/index.php?action=edit&id=" . $banner->getId() . "'><span class='icon-pencil'></span></a></td>
                <td><a  href='".ROOT."/backend/banner/index.php?action=delete&id=" . $banner->getId() . "'><span class='icon-trashcan'></span></a></td>
               </tr>";
        }
        ?>
    </tbody>
</table>