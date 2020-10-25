<?php
namespace App\Services;

use DateTime;
use DateInterval;
use App\Models\PointageQuery;



class BoardService
{
    public $generalExtraPerWeek = [];

    private $data = [];

    public function getData(Array $params)
    {
        error_log("get Data");
        $listBasique = $this->getListBasique($params);
        // dump($listBasique);
        // $listGrouped = $this->groupListByUser($listBasique);
        $this->calculate($listBasique);
        // dump($this->data);
        $this->formatData();
        return [
            "data" =>$this->data ,
            "extraPerWeek" => $this->generalExtraPerWeek
        ];
    }

    public function formatData()
    {
        foreach ($this->data as $key => $oneUser) {
            $this->formatOneDateInterval($this->data[$key]['result']->totalWork);
            $this->formatOneDateInterval($this->data[$key]['result']->totalNormal);
            $this->formatOneDateInterval($this->data[$key]['result']->totalExtra);
            $this->formatOneDateInterval($this->data[$key]['result']->samedi);
            $this->formatOneDateInterval($this->data[$key]['result']->day);
            $this->formatOneDateInterval($this->data[$key]['result']->night);
            $this->formatOneDateInterval($this->data[$key]['result']->manque);
        }
    }

    public function formatOneDateInterval(DateInterval &$interval)
    {
        // dump($interval);
        $interval->h += $interval->s / 3600;
        
        $interval->i += ($interval->s - ($interval->h * 3600)) / 60;
        $interval->s  = $interval->s - (($interval->h * 3600) + ($interval->i * 60));
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
        // ->filterByEmployeId(15)
        ->joinEmploye()
        ->withColumn("nom_prenom")
        ->withColumn("poste");

        if(array_key_exists("employe_id",$params)){
            $query->filterByEmployeId($params['employe_id']);
        }
        return $query->find();
    }

    public function calculate($listPointage)
    {
        // dump("begin calculate");

        foreach ($listPointage as $key => $pointage) {
            // dump($pointage->getStatus());
            // dump($pointage->getDatePointage());
            $employe_id = $pointage->getEmployeId();
            if(!array_key_exists($employe_id,$this->data)){
                
                $this->data[$employe_id] = [];
                $this->data[$employe_id]['last'] = $pointage;
                $this->data[$employe_id]['result'] = $pointage;
                $this->data[$employe_id]['error'] = 0;
                $this->data[$employe_id]['warning'] = 0;
                continue;
            }
            if(!$this->data[$employe_id]['last']){
                $this->data[$employe_id]['last'] = $pointage;
                continue;
            } 

            $diff = $this->data[$employe_id]['last']->getDatePointage()->diff($pointage->getDatePointage());
            
            $ok = $this->checkError($employe_id,$pointage,$diff);
            if(!$ok) {
                
                $ok = $this->checkIfSaturdayDayWork($employe_id,$pointage,$diff);
            }
            if(!$ok) {
                $ok = $this->checkIfNightDayWork($employe_id,$pointage,$diff);
            }
            if(!$ok){
                $this->checkIfDayWork($employe_id,$pointage,$diff);     
            }
        }
        return;
    }

    public function checkError($employe_id,$newPointage,$diff)
    {
        // error_log("check error Debut");
        
        if(!$newPointage->isValid()){
            $this->data[$employe_id]['error'] ++;
            return true;
        }
        if($diff->d || $diff->m || $diff->y || $diff->h > 23){
            $this->data[$employe_id]['error'] ++;
            $this->data[$employe_id]['last'] = null;
            return true;
        }
        
        if($this->data[$employe_id]['last']->getStatus() == $newPointage->getStatus()){
            if($diff->h == 0) {
                $this->data[$employe_id]['warning'] ++;
                return true;
            }else{
                $this->data[$employe_id]['error'] ++;
                $this->data[$employe_id]['last'] = $newPointage;
                return true;
            }
        }

        if($newPointage->isIn()){
            $this->data[$employe_id]['last'] = $newPointage;
            return true;
        }

        if(!$this->data[$employe_id]['last']->isIn()){
            $this->data[$employe_id]['error'] ++;
            $this->data[$employe_id]['last'] = null;
            return true;
        }
        
        return;
    }

    public function checkIfSaturdayDayWork($employe_id,$newPointage,$diff)
    {
        // error_log("check saturday Debut");
        if($newPointage->getDatePointage()->format('N') < 6 || $this->data[$employe_id]['last']->getDatePointage()->format('N') < 6) return;

        $this->data[$employe_id]['result']->addInterval($diff, $this->data[$employe_id]['result']->totalWork);
        $this->data[$employe_id]['result']->addInterval($diff, $this->data[$employe_id]['result']->samedi);
        $this->data[$employe_id]['last'] = null;
        $this->data[$employe_id]['result']->jourPresence++;
        // error_log("check saturday fin");
        return true;
    }

    public function checkIfNightDayWork($employe_id, $newPointage,$diff)
    {
        // error_log("check checkIfNightDayWork debut");
        if(!$newPointage){
            error_log("new pointage null");
        }
        if(!$this->data[$employe_id]['last']){
            error_log("last null");
        }
        if($newPointage->getDatePointage()->format('N') == $this->data[$employe_id]['last']->getDatePointage()->format('N')) return;

        $this->addDifference($employe_id, $newPointage,$diff, false);
        $this->data[$employe_id]['result']->jourPresence++;
        // error_log("check checkIfNightDayWork fin");
        $this->data[$employe_id]['last'] = null;
        return true;
    }   

    

    public function checkIfDayWork($employe_id, $newPointage,$diff)
    {

        if($newPointage->getDatePointage()->format('N') != $this->data[$employe_id]['last']->getDatePointage()->format('N')) return;
        // dump("isDay");
        $this->addDifference($employe_id, $newPointage,$diff);
        $this->data[$employe_id]['last'] = null;
        $this->data[$employe_id]['result']->jourPresence++;
        return true;

    }

    public function addDifference($employe_id, $newPointage,$diff, $isDay = true)
    {   
        // error_log("check addDifference debut");
        $week = $this->data[$employe_id]['last']->getDatePointage()->format("W");
        $diff->h -= $isDay ? $newPointage::DAY_PAUSE : $newPointage::NIGHT_PAUSE;
        $this->data[$employe_id]['result']->addInterval($diff, $this->data[$employe_id]['result']->totalWork);
        if($isDay){
            $this->data[$employe_id]['result']->addInterval($diff, $this->data[$employe_id]['result']->day);
        }else {
            $this->data[$employe_id]['result']->addInterval($diff, $this->data[$employe_id]['result']->night);
        }
        $keyNormal = "PT".$newPointage::NORMAL_HOUR."H";
        $keyWithPause = "PT".($newPointage::NORMAL_HOUR + ($isDay ? $newPointage::DAY_PAUSE : $newPointage::NIGHT_PAUSE))."H";
        
        $intervalNormalWork = new DateInterval($keyNormal);
        $intervalNormalWorkWithPause = new DateInterval($keyWithPause);

        

        $lastDateWithNormalHours = $this->data[$employe_id]['last']->getDatePointage()->add($intervalNormalWorkWithPause);

        $diff = $newPointage->getDatePointage()->diff($lastDateWithNormalHours);

        
        
        $this->data[$employe_id]['result']->addInterval($intervalNormalWork, $this->data[$employe_id]['result']->totalNormal);
        if($diff->invert){
            $this->addExtra($diff,$employe_id, $week);
        }else{
            $this->data[$employe_id]['result']->addInterval($diff, $this->data[$employe_id]['result']->manque);
        }
        // error_log("check addDifference fin");
    }

    public function addExtra(DateInterval $interval, $employe_id, $week)
    {
        error_log("check addExtra debut");
        $this->data[$employe_id]['result']->addInterval($interval,$this->data[$employe_id]['result']->totalExtra);

        if(!array_key_exists($week,$this->data[$employe_id]['result']->extraPerWeek)){
            $this->data[$employe_id]['result']->extraPerWeek[$week] = [];
            $this->data[$employe_id]['result']->extraPerWeek[$week]["firstExtra"] = 0;
            $this->data[$employe_id]['result']->extraPerWeek[$week]["others"] = 0;
        }

        if(!array_key_exists($week,$this->generalExtraPerWeek)){
            $this->generalExtraPerWeek[$week] = true;
        }

        $intervalInSeconds = ($interval->h * 60 * 60) + ($interval->i * 60) + ($interval->s);
        error_log("interval in seconds : " . $intervalInSeconds);
        error_log($this->data[$employe_id]['result']->extraPerWeek[$week]["firstExtra"]);
        if($this->data[$employe_id]['result']->extraPerWeek[$week]["firstExtra"] > $this->data[$employe_id]['result']::EIGHT_EXTRA){
            
            $this->data[$employe_id]['result']->extraPerWeek[$week]["others"] += $intervalInSeconds;
        }elseif (($this->data[$employe_id]['result']->extraPerWeek[$week]["firstExtra"] + $intervalInSeconds) > $this->data[$employe_id]['result']::EIGHT_EXTRA) {
            $surplus = ($this->data[$employe_id]['result']->extraPerWeek[$week]["firstExtra"] + $intervalInSeconds) - $this->data[$employe_id]['result']::EIGHT_EXTRA;
            $this->data[$employe_id]['result']->extraPerWeek[$week]["firstExtra"] = $this->data[$employe_id]['result']::EIGHT_EXTRA;
            $this->data[$employe_id]['result']->extraPerWeek[$week]["others"] += $surplus;
        }else{
            $this->data[$employe_id]['result']->extraPerWeek[$week]["firstExtra"]+= $intervalInSeconds;
        }
        error_log("check addExtra end");
    }


}