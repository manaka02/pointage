<?php
namespace App\Services;

use DateTime;
use DateInterval;
use App\Models\PointageQuery;



class BoardService
{
    public $generalExtraPerWeek = [];

    public function getData(Array $params)
    {
        error_log("get Data");
        $listBasique = $this->getListBasique($params);
        
        $listGrouped = $this->groupListByUser($listBasique);
        $data = $this->calculate($listGrouped);
        dump($data);
        return [
            "data" =>$data ,
            "extraPerWeek" => $this->generalExtraPerWeek
        ];
    }

    public function getListBasique(Array $params)
    {
        error_log("get list basique");
        $date_fin = new DateTime();
        $date_debut = (new DateTime())->sub(new DateInterval('P7D'));
        if(array_key_exists("date_fin",$params)){
            $date_fin = DateTime::createFromFormat('Y-m-d',$params['date_fin'] );
        }
        if(array_key_exists("date_debut",$params)){
            $date_debut = DateTime::createFromFormat('Y-m-d',$params['date_debut'] );
        }
        $query = PointageQuery::create()
        ->filterByDatePointage(array('min' => $date_debut, 'max' => $date_fin))
        ->orderByDatePointage("asc")
        ->joinEmploye()
        ->withColumn("nom_prenom")
        ->withColumn("employe_pointage_id")
        ->withColumn("poste");

        if(array_key_exists("employe_id",$params)){
            $query->filterByEmployeId($params['employe_id']);
        }
        return $query->find();
    }

    public function groupListByUser($listBasique)
    {
        error_log("get list grouped");
        $grouped = [];
        foreach ($listBasique as $key => $pointage) {
            if(!array_key_exists($pointage->getEmployeId(), $grouped)){
                $grouped[$pointage->getEmployeId()] = [];
            }
            array_push($grouped[$pointage->getEmployeId()],$pointage);
        }

        return $grouped;
    }

    public function calculate($listGrouped)
    {
        dump("begin calculate");
        $results = [];
        foreach ($listGrouped as $key => $oneUserList) {
            $recap = $this->calculateForOneUser($oneUserList);
            array_push($results,$recap);
        }
        return $results;
    }

    public function calculateForOneUser($userList)
    {
        $result = $userList[0];
        $lastPointage = null;
        
        foreach ($userList as $key => $pointage) {
            $ok = null;
            $ok = $this->checkError($result,$lastPointage,$pointage);
            if(!$ok) {
                $this->checkIfSaturdayDayWork($result,$lastPointage,$pointage);
            }
            if(!$ok) {
                $this->checkIfNightDayWork($result,$lastPointage,$pointage);
            }
            if(!$ok){
                $ok = $this->checkIfDayWork($result,$lastPointage,$pointage);
            }
        }
        return $result;
    }

    public function checkError(&$result, &$lastPointage,$newPointage)
    {
        if(!$lastPointage){
            $lastPointage = $newPointage;
            return;
        } 
        $diff = $lastPointage->getDatePointage()->diff($newPointage->getDatePointage());
        if($diff->d > 0 || $diff->m > 0 || $diff->y > 0 || $diff->h > 23){
            array_push($result->dateErrorList, $lastPointage);
            $lastPointage = null;
            return true;
        }
        if($lastPointage->getStatus() == $newPointage->getStatus()){
            if($diff->h == 0) {
                $lastPointage = $newPointage;
                return true;
            }else{
                array_push($result->dateErrorList, $lastPointage);
                $lastPointage = null;
                return true;
            }
        }
        return;
    }

    public function checkIfSaturdayDayWork(&$result, &$lastPointage,$newPointage)
    {
        if(!$lastPointage) return;
        if($newPointage->getDatePointage()->format('N') < 6 || $lastPointage->getDatePointage()->format('N') < 6) return;
        if($newPointage->isIn()) return;

        $diff = $lastPointage->getDatePointage()->diff($newPointage->getDatePointage());
        $result->addInterval($diff, $result->totalWork);
        $result->addInterval($diff, $result->samedi);
        $lastPointage = $newPointage;
        return true;
    }

    public function checkIfNightDayWork(&$result,&$lastPointage, $newPointage)
    {
        if(!$lastPointage) return;
        if($newPointage->getDatePointage()->format('N') == $lastPointage->getDatePointage()->format('N')) return;
        if($newPointage->isIn()) return;
        $diff = $lastPointage->getDatePointage()->diff($newPointage->getDatePointage());
        $result->addInterval($diff, $result->totalWork);
        $result->addInterval($diff, $result->night);

        $this->addDifference($result,$lastPointage, $newPointage, false);
        $lastPointage = $newPointage;
        return true;
    }   

    

    public function checkIfDayWork(&$result,&$lastPointage, $newPointage)
    {
        if(!$lastPointage) return;
        $heureDePointe = $newPointage->getDatePointage()->format('H');

        if($newPointage->isIn()) return;
        if($newPointage->getDatePointage()->format('N') != $lastPointage->getDatePointage()->format('N')) return;
        
        $this->addDifference($result,$lastPointage, $newPointage);
        $lastPointage = $newPointage;
        return true;

    }

    public function addDifference(&$result, $lastPointage, $newPointage, $isDay = true)
    {
        $week = $lastPointage->getDatePointage()->format("W");
        $totalWork = $lastPointage->getDatePointage()->diff($newPointage->getDatePointage());
        $totalWork->h -= $isDay ? $result::DAY_PAUSE : $result::NIGHT_PAUSE;
        if($isDay){
            $result->addInterval($totalWork, $result->day);
        }else {
            $result->addInterval($totalWork, $result->night);
        }
        $keyNormal = "PT".$result::NORMAL_HOUR."H";
        $keyWithPause = "PT".($result::NORMAL_HOUR + ($isDay ? $result::DAY_PAUSE : $result::NIGHT_PAUSE))."H";
        
        $intervalNormalWork = new DateInterval($keyNormal);
        $intervalNormalWorkWithPause = new DateInterval($keyWithPause);
        $lastDateWithNormalHours = $lastPointage->getDatePointage()->add($intervalNormalWorkWithPause);

        $diff = $newPointage->getDatePointage()->diff($lastDateWithNormalHours);

        

        $result->addInterval($totalWork, $result->totalWork);
        $result->addInterval($intervalNormalWork, $result->totalNormal);
        if($diff->invert){
            $result->addInterval($diff, $result->totalExtra);
            $this->addExtra($diff, $result, $week);
        }else{
            $result->addInterval($diff, $result->manque);
            
        }
    }

    public function addExtra(DateInterval $interval, $target, $week)
    {
        $target->addInterval($interval,$target->totalExtra);

        if(!array_key_exists($week,$target->extraPerWeek)){
            $target->extraPerWeek[$week] = [];
            $target->extraPerWeek[$week]["firstExtra"] = 0;
            $target->extraPerWeek[$week]["others"] = 0;
        }

        if(!array_key_exists($week,$this->generalExtraPerWeek)){
            array_push($this->generalExtraPerWeek, $week);
        }

        $intervalInSeconds = ($interval->h * 60 * 60) + ($interval->i * 60) + ($interval->s);

        if($target->extraPerWeek[$week]["firstExtra"] > $target::EIGHT_EXTRA){
            $target->extraPerWeek[$week]["others"] += $intervalInSeconds;
        }elseif (($target->extraPerWeek[$week]["firstExtra"] + $intervalInSeconds) > $target::EIGHT_EXTRA) {
            $surplus = ($target->extraPerWeek[$week]["firstExtra"] + $intervalInSeconds) - $target::EIGHT_EXTRA;
            $target->extraPerWeek[$week]["firstExtra"] = $target::EIGHT_EXTRA;
            $target->extraPerWeek[$week]["others"] += $surplus;
        }else{
            $target->extraPerWeek[$week]["firstExtra"]+= $intervalInSeconds;
        }
    }


}