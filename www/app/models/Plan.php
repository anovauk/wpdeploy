<?php

use Phalcon\Mvc\Model;

class Plan extends Model {

	protected $id;
	protected $plan_name;
	protected $whm_plan_name;

	/**
     * This function is called only once every application initialisation
     */
    public function initialize() {
        // Set the source table
        $this->setSource('Plan');
    }

    public function getID() {
    	return $this->id;
    }

    public function getPlanName() {
    	return $this->plan_name;
    }

    public function getWHMPlanName() {
    	return $this->whm_plan_name;
    }

    public function setPlanName($plan_name) {
    	$this->plan_name = $plan_name;
    	return $this;
    }

    public function setWHMPlanName($whm_plan_name) {
    	$this->whm_plan_name = $whm_plan_name;
    	return $this;
    }

}