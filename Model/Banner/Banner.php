<?php
namespace Model\Banner;

/**
 * @author cboucly
 */
class Banner {
    
    const TABLE_NAME = "banner";
    private $id;
    private $campaign_id;
    private $img;
    private $filename;
    private $is_activated;
    private $created_at;
    private $updated_at;
    
    function __construct(){
      
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCampaignId() {
        return $this->campaign_id;
    }

    public function setCampaignId($campaign_id) {
        $this->campaign_id = $campaign_id;
    }

    public function getImg() {
        return $this->img;
    }

    public function setImg($img) {
        $this->img = $img;
    }

    public function getFilename() {
        return $this->filename;
    }

    public function setFilename($filename) {
        $this->filename = $filename;
    }

    public function getIsActivated() {
        return $this->is_activated;
    }

    public function setIsActivated($is_activated) {
        $this->is_activated = $is_activated;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
    
    public function prepareData($data){
         
        if(isset($data['id']) && $data['id'])
            $this->setId($data['id']);
        
        if(isset($data['campaign_id']) && $data['campaign_id'])
            $this->setCampaignId($data['campaign_id']);
        
        if(isset($data['img']) && $data['img'])
            $this->setImg($data['img']);
        
          if(isset($data['filename']) && $data['filename'])
            $this->setFilename($data['filename']);
        
        if(isset($data['is_activated']) && $data['is_activated'])
            $this->setIsActivated($data['is_activated']);
        
         if(isset($data['created_at']) && $data['created_at'])
            $this->setCreatedAt($data['created_at']);
        
        if(isset($data['updated_at']) && $data['updated_at'])
            $this->setUpdatedAt($data['updated_at']);
        
        
        return $this;
    }




}
