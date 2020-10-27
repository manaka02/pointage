<?php

namespace App\Models;

use App\Services\GeneralService;
use App\Models\Base\Debauche as BaseDebauche;

/**
 * Skeleton subclass for representing a row from the 'debauche' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Debauche extends BaseDebauche
{
    private $addmore = true;

    public function getAddmore()
    {
        return $this->addmore;
    }

    public function getTitle()
    {
        return "Debauche";
    }

    public function joinOtherColummns(&$query)
    {
        $query   
                ->useDepartementQuery()
                ->withColumn('Departement.designation','departement')            
                ->endUse();
            
    }

    public function keyCrud()
    {
        $departement = GeneralService::getTargetAsChoice('departement','designation');
        return [
            
            [
                "path" => "civilite",
                "key" => "Civilité"
            ],
            [
                "path" => "ref_interne",
                "key" => "N° matricule"
            ],
            [
                "path" => "nom_prenom",
                "key" => "Nom & prénoms"
            ],
            [
                "path" => "fonction",
                "key" => "Fonction"
            ],
            [
                "path" => "departement_id",
                "key" => "Département",
                "value" => $departement,
                "type" => 'select',
            ],
            [
                "path" => "date_embauche",
                "key" => "Date embauche",
                "type" => "date"
            ],
            [
                "path" => "date_depart",
                "key" => "Date de départ",
                "type" => "date"
            ],
            [
                "path" => "raisons",
                "key" => "Raison du départ",
            ],
            [
                "path" => "motif",
                "key" => "Motifs de départ",
            ]
            ];
    }

    public function getKeySearch()
    {
        $departement = GeneralService::getTargetAsChoice('departement','designation');
        return [

            [
                "path" => "ref_interne",
                "key" => "N° matricule"
            ],
            [
                "path" => "nom_prenom",
                "key" => "Nom & prénoms"
            ],
            [
                "path" => "fonction",
                "key" => "Fonction"
            ],
            [
                "path" => "departement_id",
                "key" => "Département",
                "value" => $departement,
                "type" => 'select',
            ],
            [
                "path" => "date_embauche",
                "key" => "Date d'embauche",
                "type" => "date"
            ],
            
            [
                "path" => "date_depart",
                "key" => "Date de depart",
                "type" => "date"
            ],
            [
                "path" => "raisons",
                "key" => "Raison du départ",
            ],
            [
                "path" => "motif",
                "key" => "Motifs de départ",
            ]
        ];
    }

    private $keyToShow =[
        "ref_interne","civilite","nom_prenom", "fonction", "departement_id", "date_embauche", "date_depart", "raisons", "motif"
   ];

   private $keyText = [
       
       "N° matricule",
       "Civilité",
       "Nom & prénoms",
       "fonction",
       "Département",
       "date début",
       "Date de depart",
       "Raison du départ",
       "Motifs de départ"

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
