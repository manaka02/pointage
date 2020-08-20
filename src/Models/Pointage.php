<?php

namespace App\Models;

use App\Models\Employe;
use App\Services\GeneralService;
use Propel\Runtime\ActiveQuery\Criteria;
use App\Models\Base\Pointage as BasePointage;

/**
 * Skeleton subclass for representing a row from the 'pointage' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Pointage extends BasePointage
{
    private $addmore = true;

    public function getAddmore()
    {
        return $this->addmore;
    }

    public function setAddmore($addmore)
    {
        return $this->addmore = $addmore;
    }
    public function getTitle()
    {
        return "Pointage";
    }

    public function joinOtherColummns(&$query)
    {
        $query->joinEmploye(null,Criteria::LEFT_JOIN);

        $query->withColumn('Employe.employe_pointage_id', 'no_employe');
        $query->withColumn('Employe.ref_interne', 'ref_interne');
        $query->withColumn('Employe.nom_prenom', 'nom_prenom');
        $query->withColumn('Employe.genre', 'genre');
        $query->withColumn('Employe.poste', 'poste');
    }

    private $keyToShow =[
        "no_employe", "ref_interne", "nom_prenom", "date_pointage", "status"
    ];

    private $keyText = [

        "N° Pointeur",
        "Réf Interne",
        "Nom et prénoms",
        
        "Statut",
        "Date de pointage",
    ];

    /**
     * Get the value of keySearch
     */ 
    public function getKeySearch()
    {
        return [
            [
                "path" => "no_employe",
                "key" => "N° Pointeur"
            ],
            [
                "path" => "ref_interne",
                "key" => "Ref Interne"
            ],
            [
                "path" => "nom_prenom",
                "key" => "Nom et prénoms"
            ],
            [
                "path" => "status",
                "key" => "Statut",
                "value" => GeneralService::getChoice("pointage", "status"),
                "type" => 'select',
            ],
            [
                "path" => "date_pointage",
                "key" => "Date de pointage",
                "type" => "date"
            ]
        ];
    }

    public function keyCrud()
    {
        $employe = (new Employe())->getAllEmployeAsChoice();
        return [
            [
                "path" => "employe_id",
                "key" => "Nom de l'employé",
                "value" => $employe,
                "type" => 'select',
            ],
            [
                "path" => "date_pointage",
                "key" => "Date et heure de pointage",
                "type" =>"datetime"
            ],
            [
                "path" => "status",
                "key" => "Type de Pointage",
                "value" => GeneralService::getChoice("pointage", "status"),
                "type" => 'select',
            ]
        ];
    }
    

    /**
     * Get the value of keyToShow
     */ 
    public function getKeyToShow()
    {
        return $this->keyToShow;
    }

    /**
     * Get the value of keyText
     */ 
    public function getKeyText()
    {
        return $this->keyText;
    }
}
