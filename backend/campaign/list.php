<?php
$campaign = new Controller\Campaign($pdo);
$listCampaigns = $campaign->listCampaigns();
?>
<h2>Liste des campagnes</h2>
<a class="btn btn-info" href='<?php echo ROOT ?>/backend/campaign/index.php?action=add'><span class='icon-plus'></span>  Créer une campagne</a>
<br /><br /><table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th></th>
            <th></th>
        </tr>
    <tbody>
        <?php
        foreach ($listCampaigns as $campaign) {
            
            echo "<tr ".(($campaign->getIsActivated()==0)?'class=\'error\'':'').">
                <td>" . $campaign->getId() . "</td>
                <td>" . $campaign->getName() . "</td>
                <td>" . $campaign->getDescription() . "</td>
                <td>" . $campaign->getCreatedAt() . "</td>
                <td>" . $campaign->getUpdatedAt() . "</td>
                <td><a href='index.php?action=edit&id=" . $campaign->getId() . "'><span class='icon-pencil'></span></a></td>
                <td><a  href='index.php?action=delete&id=" . $campaign->getId() . "'><span class='icon-trashcan'></span></a></td>
               </tr>";
        }
        ?>
    </tbody>
</table>