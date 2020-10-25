<?php

namespace App\Models;

use DateInterval;
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
    const DAY_WORK_START_OUT = 9;
    const DAY_WORK_END_OUT = 18;
    const NIGHT_WORK_START_OUT = 16;
    const NIGHT_WORK_END_OUT = 22;
    const PAUSE = 1;
    const NORMAL_HOUR = 8;
    const DAY_PAUSE = 1;
    const NIGHT_PAUSE = 0;
    const EIGHT_EXTRA = 28800;

    const OUT = "C/Out";
    const IN = "C/In";

    


    public $totalWork;
    public $totalNormal;
    public $totalExtra;
    public $samedi;
    public $night;
    public $day;
    public $jourPresence = 0;
    public $manque;
    private $addmore = true;
    public $extraPerWeek = [];
    public $dateErrorList = [];

    public function __construct() {
        $this->totalWork = new DateInterval("PT0H0S");
        $this->totalNormal = new DateInterval("PT0H0S");
        $this->totalExtra = new DateInterval("PT0H0S");
        $this->samedi = new DateInterval("PT0H0S");
        $this->night = new DateInterval("PT0H0S");
        $this->day = new DateInterval("PT0H0S");
        $this->manque = new DateInterval("PT0H0S");
    }


    public function isOut()
    {
        if($this->status == self::OUT) return true;
        return false; 
    }

    public function isValid()
    {
        if($this->status != self::OUT && $this->status != self::IN){
            return false;
        }
        return true;
    }

    

    public function addInterval(DateInterval $interval, &$target)
    {
        $target->s += $interval->s + ($interval->i * 60) + ($interval->h * 3600); 
    }

    public function isIn()
    {
        if($this->status == self::IN) return true;
        return false; 
    }

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

        $query->withColumn('Employe.ref_interne', 'ref_interne');
        $query->withColumn('Employe.nom_prenom', 'nom_prenom');
        $query->withColumn('Employe.genre', 'genre');
        $query->withColumn('Employe.poste', 'poste');
    }

    private $keyToShow =[
        "employe_id", "nom_prenom", "date_pointage", "status"
    ];

    private $keyText = [
        "Réf Interne",
        "Nom et prénoms",
        "Date de pointage",
        "Statut",
    ];

    /**
     * Get the value of keySearch
     */ 
    public function getKeySearch()
    {
        return [
            [
                "path" => "employe_id",
                "key" => "N° matricule",
                "type" => "number"
            ],
            [
                "path" => "Employe%nom_prenom",
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
