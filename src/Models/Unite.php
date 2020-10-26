<?php

namespace App\Models;

use App\Services\GeneralService;
use App\Models\Base\Unite as BaseUnite;

/**
 * Skeleton subclass for representing a row from the 'unite' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Unite extends BaseUnite
{
    private $addmore = true;

    public function getAddmore()
    {
        return $this->addmore;
    }

    public function getTitle()
    {
        return "Unité";
    }

    public function joinOtherColummns(&$query)
    {
        $query
            ->useServiceQuery()
            ->withColumn('Service.designation','service')
                ->useDepartementQuery()
                ->withColumn('Departement.designation','departement')
                    ->useDirectionQuery()
                    ->withColumn('Direction.designation', 'direction')
                    ->endUse()
                ->endUse()
            ->endUse();

            
    }



    public function keyCrud()
    {
        $service = GeneralService::getTargetAsChoice('service','designation');
        return [
            
            [
                "path" => "designation",
                "key" => "Désignation"
            ],
            [
                "path" => "description",
                "key" => "Déscription"
            ],[
                "path" => "service_id",
                "key" => "Service",
                "value" => $service,
                "type" => 'select',
            ]
            ];
    }

    public function getKeySearch()
    {
        $direction = GeneralService::getTargetAsChoice('direction','designation');
        $departement = GeneralService::getTargetAsChoice('departement','designation');
        $service = GeneralService::getTargetAsChoice('service','designation');
        return [
            [
                "path" => "designation",
                "key" => "designation",
                
            ],[
                "path" => "service_id",
                "key" => "Service",
                "type"  => "select",
                "value" => $service
            ],
            [
                "path" => "Service%departement_id",
                "key" => "Départment",
                "type"  => "select",
                "value" => $departement
            ],[
                "path" => "Service%Departement%direction_id",
                "key" => "Direction",
                "type"  => "select",
                "value" => $direction
            ]
        ];
    }

    private $keyToShow =[
        "designation","service","departement","direction", "description"
   ];

   private $keyText = [
       "Désignation",
       "Service",
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
