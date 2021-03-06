<?php

namespace App\Models;

use App\Services\GeneralService;
use App\Models\Base\Service as BaseService;

/**
 * Skeleton subclass for representing a row from the 'service' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Service extends BaseService
{
    private $addmore = true;

    public function getAddmore()
    {
        return $this->addmore;
    }

    public function getTitle()
    {
        return "Service";
    }

    public function joinOtherColummns(&$query)
    {
        $query   
                ->useDepartementQuery()
                ->withColumn('Departement.designation','departement')
                    ->useDirectionQuery()
                    ->withColumn('Direction.designation', 'direction')
                    ->endUse()
                ->endUse();
            
    }



    public function keyCrud()
    {
        $departement = GeneralService::getTargetAsChoice('departement','designation');
        return [
            
            [
                "path" => "designation",
                "key" => "Désignation"
            ],
            [
                "path" => "description",
                "key" => "Déscription"
            ],[
                "path" => "departement_id",
                "key" => "Département",
                "value" => $departement,
                "type" => 'select',
            ]
            ];
    }

    public function getKeySearch()
    {
        $direction = GeneralService::getTargetAsChoice('direction','designation');
        $departement = GeneralService::getTargetAsChoice('departement','designation');
        return [
            [
                "path" => "designation",
                "key" => "designation",
                
            ],[
                "path" => "departement_id",
                "key" => "Départment",
                "type"  => "select",
                "value" => $departement
            ],[
                "path" => "Departement%direction_id",
                "key" => "Direction",
                "type"  => "select",
                "value" => $direction
            ]
        ];
    }

    private $keyToShow =[
        "designation","departement","direction", "description"
   ];

   private $keyText = [
       "Désignation",
       "Département",
       "Direction",
       "Description"

   ];

    /**
     * Get the value of keyToShow
     */ 
    public function getKeyToShow()
    {
        return $this->keyToShow;
    }

    /**
     * Set the value of keyToShow
     *
     * @return  self
     */ 
    public function setKeyToShow($keyToShow)
    {
        $this->keyToShow = $keyToShow;

        return $this;
    }

    /**
     * Get the value of keyText
     */ 
    public function getKeyText()
    {
        return $this->keyText;
    }

    /**
     * Set the value of keyText
     *
     * @return  self
     */ 
    public function setKeyText($keyText)
    {
        $this->keyText = $keyText;

        return $this;
    }
}
