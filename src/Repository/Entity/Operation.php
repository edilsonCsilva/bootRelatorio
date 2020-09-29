<?php
namespace Stilldistribuidora\Repository\Entity;


class Operation{

    private $ObjId;
    private $delivery_id;
    private $dt_processed;
    private $status;
    private $dt_processing;
    private $metadata;
    private $delivery_raw;

    function __construct($ObjId="",$delivery_id="",$dt_processed="",$status="",
    $dt_processing="",$metadata="",$delivery_raw="")
    {

        $this->ObjId=$ObjId;
        $this->delivery_id=$delivery_id;
        $this->dt_processed=$dt_processed;
        $this->status=$status;
        $this->dt_processing=$dt_processing;
        $this->metadata=$metadata;
        $this->delivery_raw=$delivery_raw;


        
    }


    /**
     * Get the value of ObjId
     */ 
    public function getObjId()
    {
        return $this->ObjId;
    }

    /**
     * Set the value of ObjId
     *
     * @return  self
     */ 
    public function setObjId($ObjId)
    {
        $this->ObjId = $ObjId;

        return $this;
    }

    /**
     * Get the value of delivery_id
     */ 
    public function getDelivery_id()
    {
        return $this->delivery_id;
    }

    /**
     * Set the value of delivery_id
     *
     * @return  self
     */ 
    public function setDelivery_id($delivery_id)
    {
        $this->delivery_id = $delivery_id;

        return $this;
    }

    /**
     * Get the value of dt_processed
     */ 
    public function getDt_processed()
    {
        return $this->dt_processed;
    }

    /**
     * Set the value of dt_processed
     *
     * @return  self
     */ 
    public function setDt_processed($dt_processed)
    {
        $this->dt_processed = $dt_processed;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of dt_processing
     */ 
    public function getDt_processing()
    {
        return $this->dt_processing;
    }

    /**
     * Set the value of dt_processing
     *
     * @return  self
     */ 
    public function setDt_processing($dt_processing)
    {
        $this->dt_processing = $dt_processing;

        return $this;
    }

    /**
     * Get the value of metadata
     */ 
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set the value of metadata
     *
     * @return  self
     */ 
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get the value of delivery_raw
     */ 
    public function getDelivery_raw()
    {
        return $this->delivery_raw;
    }

    /**
     * Set the value of delivery_raw
     *
     * @return  self
     */ 
    public function setDelivery_raw($delivery_raw)
    {
        $this->delivery_raw = $delivery_raw;

        return $this;
    }
}
   
  


?>

