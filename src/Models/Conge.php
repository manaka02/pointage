<?php

namespace App\Models;

use App\Services\GeneralService;
use App\Models\Base\Conge as BaseConge;

/**
 * Skeleton subclass for representing a row from the 'conge' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Conge extends BaseConge
{
    private $addmore = true;

    public function getAddmore()
    {
        return $this->addmore;
    }

    public function getTitle()
    {
        return "Congé";
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
        $employes = GeneralService::getTargetAsChoice('service','designation');

        return [
            [
                "path" => "employe_id",
                "key" => "Employés",
                "value" => $employes,
                "type" => 'select',
            ],
            [
                "path" => "date_debut",
                "key" => "Date de début",
                "type" =>"date"
            ],
            [
                "path" => "date_fin",
                "key" => "Date reprise",
                "type" =>"date"
            ],
            [
                "path" => "date_demande",
                "key" => "Date de demande",
                "type" =>"date"
            ],[
                "path" => "motif",
                "key" => "Motif de congé",
                "type" => 'text',
            ],[
                "path" => "status",
                "key" => "Statut",
                "type" => 'text',
                "value" => $employes,
                "type" => 'select',
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
                "key" => "Direction",
                "type"  => "select",
                "value" => $direction
            ]

        ];
    }

    private $keyToShow =[
        "employe","date_debut","date_fin","date_demande","motif","service","departement","direction"
   ];

   private $keyText = [
       "Désignation",
       "Date de début",
       "Date de reprise",
       "Date de demande",
       "Motif",
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
