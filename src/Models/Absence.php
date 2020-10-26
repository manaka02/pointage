<?php

namespace App\Models;

use App\Services\GeneralService;
use App\Models\Base\Absence as BaseAbsence;

/**
 * Skeleton subclass for representing a row from the 'absence' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Absence extends BaseAbsence
{
    private $addmore = true;

    public function getAddmore()
    {
        return $this->addmore;
    }

    public function getTitle()
    {
        return "Absence";
    }

    public function joinOtherColummns(&$query)
    {
        $query
            ->useEmployeQuery()
                ->withColumn("nom_prenom","employe")
                ->useUniteQuery()
                ->withColumn('Unite.designation', 'unite')
                    ->useServiceQuery()
                    ->withColumn('Service.designation','service')
                        ->useDepartementQuery()
                        ->withColumn('Departement.designation','departement')
                            ->useDirectionQuery()
                            ->withColumn('Direction.designation', 'direction')
                            ->endUse()
                        ->endUse()
                    ->endUse()
                ->endUse()
            ->endUse();       
    }



    public function keyCrud()
    {
        $employes = GeneralService::getTargetAsChoice('employe','nom_prenom');

        return [
            [
                "path" => "employe_id",
                "key" => "Employés",
                "value" => $employes,
                "type" => 'select',
            ],
            [
                "path" => "date_absence",
                "key" => "Date absence",
                "type" =>"date"
            ]
            ];
    }

    public function getKeySearch()
    {
        $direction = GeneralService::getTargetAsChoice('direction','designation');
        $departement = GeneralService::getTargetAsChoice('departement','designation');
        $service = GeneralService::getTargetAsChoice('service','designation');
        $unite = GeneralService::getTargetAsChoice('unite','designation');
        return [
            [
                "path" => "designation",
                "key" => "designation",
                
            ],[
                "path" => "Employe%unite_id",
                "key" => "Unité",
                "type"  => "select",
                "value" => $unite
            ],[
                "path" => "Employe%Unite%service_id",
                "key" => "Service",
                "type"  => "select",
                "value" => $service
            ],[
                "path" => "Employe%Unite%Service%departement_id",
                "key" => "Département",
                "type"  => "select",
                "value" => $departement
            ]
            ,[
                "path" => "Employe%Unite%Service%Departement%direction_id",
                "key" => "Direction",
                "type"  => "select",
                "value" => $direction
            ],
            [
                "path" => "date_debut",
                "key" => "Date d'absence",
                "type"  => "date",
            ]

        ];
    }

    private $keyToShow =[
        "employe","date_absence","service","departement","direction"
   ];

   private $keyText = [
       "Employé",
       "Date de d'absence",
       
       "Service",
       "Département",
       "Direction",


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
