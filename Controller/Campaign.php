<?php
namespace Controller;

use  \Model\Banner\Campaign as Camp;
use  \Model\Banner\Banner as Ban;
/**
 * @author cboucly
 */
class Campaign {

    private $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function listCampaigns() {
        return $this->findAll();
    }

    public function editCampaign($id) {
        return $this->findOneById($id);
    }

    public function addCampaign($values) {
       
       
       
            $this->createCampaign($values);
            $id = $this->db->lastInsertId();
            return $this->findOneById($id);
        
    }
    
    
    public function updateStateCampaign($values) {
        
        $query = '
            UPDATE ' . Camp::TABLE_NAME . ' 
            SET 
                is_activated = :is_activated
            WHERE id=:id';

        $prep = $this->db->prepare($query);

        $prep->bindValue('id', $id, \PDO::PARAM_INT);
        $prep->bindValue('is_activated', $state, \PDO::PARAM_INT);
        
        

    }
     public function deleteCampaign($values) {
         
         $id = $values['id'];
         
         
         
         $query = '
            DELETE FROM ' . Camp::TABLE_NAME . ' 
             WHERE id=:id';

        $prep = $this->db->prepare($query);

        $prep->bindValue('id', $id, \PDO::PARAM_INT);
        $prep->execute();

     }
    

    public function updateCampaign($postValues) {

        $query = 'UPDATE 
                ' . Camp::TABLE_NAME . ' 
                SET 
                    name=:name, 
                    description=:description, 
                    is_activated = :is_activated,
                    updated_at = :updated_at
                WHERE 
                    id=:id';

        $this->save($query, $postValues, 'update');
    }

    private function createCampaign($postValues) {

        $query = 'INSERT INTO 
                ' . Camp::TABLE_NAME . ' 
                (name,description,is_activated,created_at) VALUES (:name,:description,:is_activated,:created_at)';

        $this->save($query, $postValues, 'add');
        //return array('success'=>true);
    }

    private function save($query, $postValues, $type) {

        $date = date('Y-m-d H:i:s');
        $prep = $this->db->prepare($query);

        $prep->bindValue('name', $postValues['name'], \PDO::PARAM_STR);
        $prep->bindValue('description', $postValues['description'], \PDO::PARAM_STR);
        $prep->bindValue('is_activated', (isset($postValues['is_activated']) ? 1 : 0), \PDO::PARAM_INT);

        if ($type == "update"){
            $prep->bindValue('id', $postValues['id'], \PDO::PARAM_INT);
            $prep->bindValue('updated_at',$date , \PDO::PARAM_STR);

        }
        if($type == "add"){
            $prep->bindValue('created_at',$date , \PDO::PARAM_STR);
        }
        

        $prep->execute();
    }

    private function findAll() {

        $campaigns = array();
        $query = 'SELECT *'
                . ' FROM ' . Camp::TABLE_NAME . ''
                . ' ORDER BY id ASC' 
                . ' LIMIT :limit' ;

        $prep = $this->db->prepare($query);

        $prep->bindValue('limit', 10, \PDO::PARAM_INT);
        $prep->execute();

        //Récupérer toutes les données retournées
        $results = $prep->fetchAll();
        if (count($results) > 0) {
            foreach ($results as $result) {
                $campaign = new \Model\Banner\Campaign();
                $campaigns[] = $campaign->prepareData($result);
            }
        }

        return $campaigns;
    }

    private function findOneById($id) {

        $campaignObj = array();
        $query = 'SELECT 
                    c.id,
                    c.name,
                    c.description,
                    c.is_activated,
                    c.created_at,
                    c.updated_at
                 FROM ' . Camp::TABLE_NAME . ' c
                 LEFT JOIN ' . Ban::TABLE_NAME . ' b on c.id = b.campaign_id
                 WHERE c.id=:id
                 ORDER BY c.id ASC' ;

      
        
        $prep = $this->db->prepare($query);

        $prep->bindValue('id', $id, \PDO::PARAM_INT);
        $prep->execute();

        //Récupérer toutes les données retournées
        $result = $prep->fetch();

        if ($result) {
            $campaign = new Camp();
            $campaignObj = $campaign->prepareData($result);
        }

        return $campaignObj;
    }

}
?>
