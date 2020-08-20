<?php

namespace App\Models;

use App\Models\Departement;
use App\Models\EmployeQuery;
use App\Services\GeneralService;
use App\Models\Base\Employe as BaseEmploye;

/**
 * Skeleton subclass for representing a row from the 'employe' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Employe extends BaseEmploye
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
        return "Employé";
    }

    public function getAllEmployeAsChoice()
    {
        $query = EmployeQuery::create()
        ->withColumn("employe_id")
        ->withColumn("nom_prenom")

        ->orderBy("nom_prenom")
        ->select("employe_id","nom_prenom");

        
        $referents = $query->find();

        $response = [];
        foreach ($referents as $key => $child) {
            $k = $child['nom_prenom'];

            $response[$k] = $child['employe_id'];
        }
        
        return $response;
    }

    public function keyCrud()
    {
        $departement = (new Departement())->getAllDepartmentAsChoice();
        return [
            [
                "path" => "employe_pointage_id",
                "key" => "Numéro de l'utilisateur dans le pointeur",
                "type" => 'number',
            ],
            [
                "path" => "ref_interne",
                "key" => "Référence en interne"
            ],
            [
                "path" => "nom_prenom",
                "key" => "Nom et prénoms"
            ],
            [
                "path" => "departement_id",
                "key" => "Nom du département",
                "value" => $departement,
                "type" => 'select',
            ],
            [
                "path" => "poste",
                "key" => "Poste"
            ],
            [
                "path" => "genre",
                "key" => "Genre",
                "value" => GeneralService::getChoice("global", "genre"),
                "type" => 'select',
            ]
        ];
    }


    private $keyToShow =[
        "employe_pointage_id", "ref_interne", "nom_prenom", "poste", "genre"
    ];

    private $keyText = [

        "N° Pointeur",
        "Réf Interne",
        "Nom et prénoms",
        "Genre",
        "Région",
    ];
    /**
     * Get the value of keySearch
     */ 
    public function getKeySearch()
    {
        return [
            [
                "path" => "employe_pointage_id",
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
                "path" => "poste",
                "key" => "Poste"
            ],
            [
                "path" => "genre",
                "key" => "Genre"
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
