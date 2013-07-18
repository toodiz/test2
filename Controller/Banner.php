<?php

namespace Controller;

use Model\Banner\Banner as Ban;
use Classes\FileUpload\FileUpload as FileUpload;

/**
 * @author cboucly
 */
class Banner {

    private $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function listByCampaignId($id) {
        return $this->findAllByCampaignId($id);
    }

    public function addBanner($postValues) {
        $this->createBanner($postValues);
        $id = $this->db->lastInsertId();
        return $this->findOneById($id);
    }

    public function editBanner($id) {
        return $this->findOneById($id);
    }

    public function updateBanner($postValues) {

        $query = 'UPDATE 
                ' . Ban::TABLE_NAME . ' 
                SET 
                    campaign_id=:campaign_id,
                    img=:img, 
                    filename=:filename, 
                    is_activated = :is_activated,
                    updated_at = :updated_at
                WHERE 
                    id=:id';

        $this->save($query, $postValues, 'update');
    }

    private function createBanner($postValues) {

        $query = 'INSERT INTO
        ' . Ban::TABLE_NAME . '
        (campaign_id,img,filename,is_activated,created_at) VALUES (:campaign_id,:img,:filename,:is_activated,NOW())';

        $this->save($query, $postValues, 'add');
    }

    public function deleteBanner($values) {

        $id = $values['id'];
        $result = $this->findOneById($id);

        if ($result) {
            $query = 'DELETE FROM ' . Ban::TABLE_NAME . ' WHERE id=:id';
            $prep = $this->db->prepare($query);
            $prep->bindValue('id', $id, \PDO::PARAM_INT);
            $prep->execute();


            if ($result->getImg() != "" && file_exists(DIR_UPLOAD  . $result->getImg())) {
                unlink(DIR_UPLOAD . $result->getImg());
            }
        }
    }

    private function save($query, $postValues, $type) {

        $date = date('Y-m-d H:i:s');
        $prep = $this->db->prepare($query);

        $prep->bindValue('campaign_id', $postValues['campaign_id'], \PDO::PARAM_STR);
        $prep->bindValue('img', $postValues['img'], \PDO::PARAM_STR);
        $prep->bindValue('filename', $postValues['filename'], \PDO::PARAM_STR);
        $prep->bindValue('is_activated', (isset($postValues['is_activated']) ? 1 : 0), \PDO::PARAM_INT);

        if ($type == "update") {
            $prep->bindValue('id', $postValues['id'], \PDO::PARAM_STR);

            $prep->bindValue('updated_at', $date, \PDO::PARAM_STR);
        }

        $prep->execute();
    }

    public function uploadFile($files) {

        if (isset($_FILES['img'])) {
            $dossier = DIR_UPLOAD;
            $fichier = strtolower(basename($_FILES['img']['name']));
            if (move_uploaded_file($_FILES['img']['tmp_name'], $dossier . $fichier)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                return array('success' => true, 'filename' => $fichier);
            } else {
                return array('success' => false);
            }
        }
    }

    private function findAllByCampaignId($id) {

        $banners = array();
        $query = 'SELECT *'
                . ' FROM ' . Ban::TABLE_NAME . ''
                . ' WHERE campaign_id =:campaign_id '
                . ' LIMIT :limit;';

        $prep = $this->db->prepare($query);

        $prep->bindValue('campaign_id', $id, \PDO::PARAM_INT);
        $prep->bindValue('limit', 10, \PDO::PARAM_INT);
        $prep->execute();

        //Récupérer toutes les données retournées
        $results = $prep->fetchAll();
        if (count($results) > 0) {
            foreach ($results as $result) {
                $banner = new Ban();
                $banners[] = $banner->prepareData($result);
            }
        }
        return $banners;
    }

    private function findOneById($id) {

        $bannerObj = array();
        $query = 'SELECT *'
                . ' FROM ' . Ban::TABLE_NAME . ''
                . ' WHERE id=:id';

        $prep = $this->db->prepare($query);

        $prep->bindValue('id', $id, \PDO::PARAM_INT);
        $prep->execute();

        //Récupérer toutes les données retournées
        $result = $prep->fetch();


        if ($result) {
            $banner = new Ban();
            $bannerObj = $banner->prepareData($result);
        }

        return $bannerObj;
    }

}

?>
