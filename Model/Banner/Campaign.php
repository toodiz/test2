<?php
namespace Model\Banner;

use  \Model\Banner\Banner as Ban;

/**
 * @author cboucly
 */
class Campaign {

    const TABLE_NAME = "campaign";

    private $id;
    private $name;
    private $description;
    private $is_activated;
    private $created_at;
    private $updated_at;
    private $banners;


    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
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

    public function getBanners() {
        return $this->banners;
    }

    public function setBanners($banners) {
        $this->banners = $banners;
    }
    public function getIsActivated() {
        return $this->is_activated;
    }

    public function setIsActivated($is_activated) {
        $this->is_activated = $is_activated;
    }

        
    
    public function prepareData($data){
         
        if(isset($data['id']) && $data['id'])
            $this->setId($data['id']);
        
        if(isset($data['name']) && $data['name'])
            $this->setName($data['name']);
        
        if(isset($data['description']) && $data['description'])
            $this->setDescription($data['description']);
        
        if(isset($data['is_activated']) && $data['is_activated'])
            $this->setIsActivated($data['is_activated']);
        
         if(isset($data['created_at']) && $data['created_at'])
            $this->setCreatedAt($data['created_at']);
        
        if(isset($data['updated_at']) && $data['updated_at'])
            $this->setUpdatedAt($data['updated_at']);
        
      
        return $this;
    }
    
    
    
}
