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

    public function addExtra(DateInterval $interval, $target, $week)
    {
        $this->addInterval($interval,$this->totalExtra);

        if(!array_key_exists($week,$this->extraPerWeek)){
            $this->extraPerWeek[$week] = [];
            $this->extraPerWeek[$week]["firstExtra"] = 0;
            $this->extraPerWeek[$week]["others"] = 0;
        }
        $intervalInSeconds = ($interval->h * 60 * 60) + ($interval->i * 60) + ($interval->s);

        if($this->extraPerWeek[$week]["firstExtra"] > self::EIGHT_EXTRA){
            $this->extraPerWeek[$week]["others"] += $intervalInSeconds;
        }elseif (($this->extraPerWeek[$week]["firstExtra"] + $intervalInSeconds) > self::EIGHT_EXTRA) {
            $surplus = ($this->extraPerWeek[$week]["firstExtra"] + $intervalInSeconds) - self::EIGHT_EXTRA;
            $this->extraPerWeek[$week]["firstExtra"] = self::EIGHT_EXTRA;
            $this->extraPerWeek[$week]["others"] += $surplus;
        }else{
            $this->extraPerWeek[$week]["firstExtra"]+= $intervalInSeconds;
        }
    }

    public function addInterval(DateInterval $interval, $target)
    {
        $target->h += $interval->h; 
        $target->i += $interval->i; 
        $target->s += $interval->s; 
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
                "path" => "Employe%no_employe",
                "key" => "N° Pointeur"
            ],
            [
                "path" => "Employe%ref_interne",
                "key" => "Ref Interne"
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
