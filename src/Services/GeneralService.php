<?php

namespace App\Services;

use Exception;
use Mpdf\Mpdf;
// use App\Dao\Dao;
// use App\Models\Osc;
// use App\Models\File;
use Aws\S3\S3Client;
// use App\Models\AcOsc;

// use App\Models\Membre;
// use App\Models\Contact;
// use App\Models\AcMembre;
// use App\Models\OscQuery;
// use App\Models\Fondation;
// use App\Models\AcOscQuery;
// use App\Models\Thematique;
// use Propel\Runtime\Propel;
use App\Models\ChoiceQuery;
// use App\Models\Financement;
// use App\Models\Gouvernance;
// use App\Models\MembreQuery;
// use App\Models\Utilisateur;

// use App\Models\Beneficiaire;
// use App\Models\ContactQuery;
// use App\Models\AcMembreQuery;
// use App\Models\Accompagnement;
// use App\Models\Base\FileQuery;
// use App\Models\FondationQuery;
// use App\Models\Identification;
// use App\Models\Map\OscTableMap;
// use App\Models\ThematiqueQuery;
// use App\Models\FinancementQuery;
// use App\Models\GouvernanceQuery;
// use App\Models\UtilisateurQuery;
use Propel\Runtime\Map\TableMap;
// use App\Models\BeneficiaireQuery;
// use App\Models\Map\AcOscTableMap;
// use App\Models\ZoneDIntervention;
// use App\Models\FichePresenceQuery;
// use App\Models\AccompagnementQuery;
// use App\Models\IdentificationQuery;

// use App\Models\Map\ContactTableMap;
// use App\Models\ParticipationReseau;
// use App\Models\Map\AcMembreTableMap;
// use App\Models\Map\FondationTableMap;
// use App\Models\Map\ThematiqueTableMap;
// use App\Models\ZoneDInterventionQuery;
// use App\Models\Map\FinancementTableMap;
// use App\Models\Map\GouvernanceTableMap;
// use App\Models\Map\BeneficiaireTableMap;
// use App\Models\ParticipationReseauQuery;
use Propel\Runtime\ActiveQuery\Criteria;
// use App\Models\Map\AccompagnementTableMap;
// use App\Models\Map\IdentificationTableMap;
// use App\Models\Map\ZoneDInterventionTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
// use App\Models\Map\ParticipationReseauTableMap;

class GeneralService
{
    private $dao;

    private static  $listTarget = [
        "beneficiaire",
        "choice",
        "financement",
        "fondation",
        "gouvernance",
        "identification",
        "echange",
        "osc_echange",
        "fiche_presence",
        "membre",
        "osc",
        "participation_reseau",
        "thematique",
        "zone_d_intervention",
        "accompagnement",
        "ac_detail",
        "ac_membre",
        "ac_formation",
        "ac_osc",
        "ac_fiche",
        "utilisateur",
        "initiative",
        "network",
        "suivi",
        "suivi_categorie",
        "recommendation",
        "equipe",
        "depense",
        "import",
        "initiative_suivi",
        "formation",
        "formation_osc",
        "formation_fiche"
    ];

    private static $alias = [
        "formateur1" => "utilisateur_id",
        "formateur2" => "utilisateur_id",
        "referent_id" => "utilisateur_id",
    ];

    public function __construct(Dao $dao = null)
    {
        $this->dao = $dao;
    }

    public static function createOrderByList($filterList)
    {
        $orderByList = [];
        foreach ($filterList as $key => $filtre) {
            $orderByList[$filtre['key']] = $filtre['path'];
        }
        # code...

        return $orderByList;
    }

    public static function generateAcronymeRegion($regionName)
    {
        switch ($regionName) {
            case 'ANALAMANGA':
                return "ANLG";
                break;
            case 'ANALANJIROFO':
                return "ANLJ";
                break;
            case 'ANOSY':
                return "ANS";
                break;
            case 'ATSIMO_ANDREFANA':
                return "ATSM";
                break;
            case 'DIANA':
                return "DIAN";
                break;
            case 'HAUTE_MATSIATRA':
                return "HAMA";
                break;
            case 'VAKINANKARATRA':
                return "VKNA";
                break;

            default:
                return "ANLG";
                break;
        }
    }

    public static function generateRandomPassword()
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, 10);
    }

    

    public static function getFiles($targetname,$target_id)
    {
        $files = FileQuery::create()
        ->filterByTarget($targetname)
        ->filterByTargetId($target_id)
        ->find();

        return self::collectionToArray($files);
        
    }

    public function getTargetAsChoice($targetname, $columnToShow, $orderBy = null)
    {
        if(!$orderBy){
            $orderBy = $columnToShow;
        }
        $query = self::invokeQuery($targetname);
        $id = $targetname.'_id';
        $query->withColumn($id)
        ->withColumn($columnToShow)
        ->orderBy($orderBy)
        ->select($id,$columnToShow);
        $referents = $query->find();
        $response = [];
        foreach ($referents as $key => $child) {
            $k = $child[$columnToShow];

            $response[$k] = $child[$id];
        }
        return $response;
    }

    public static function hasAccessToThis($user, $params)
    {
        if($user->getStatus() > 9){
            return true;
        }
        if(array_key_exists("osc_id", $params)){
            $osc = self::getTargetById("osc", $params["osc_id"]);
            if($user->getUtilisateurId() != $osc->getReferentId()){
                return false;
            }
        }
        if(array_key_exists("initiative_id",$params)){
            $initiative = self::getTargetById("initiative", $params["initiative_id"]);
            $referent_id = $initiative->getOsc()->getReferentId();
            if($user->getUtilisateurId() != $referent_id){
                return false;
            }
        }
        
        return true;
    }

    public static function group_by($key, $data) {
        $result = array();
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $newKey = $val[$key];
                unset($val[$key]);
                $result[$newKey][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
    
        return $result;
    }

    public static function configureActionLink($params,$target, $targetname)
    {
        $id = $target->getPrimaryKey();
        $pagenew = "target-new?target=$targetname";
        $pageedit = "target-edit?target=$targetname&target_id=$id";
        $pagedelete = "target-delete?target=$targetname&target_id=$id";
        $pagedetail = null;


        if (method_exists($target, "getDetailLink")) {
            $pagedetail = $target->getDetailLink();
        }
        if (method_exists($target, "getEditLink")) {
            $pageedit = $target->getEditLink();
        }
        if (method_exists($target, "getNewLink")) {
            $pagenew = $target->getNewLink();
        }
        if (method_exists($target, "getDeleteLink")) {
            $pagedelete = $target->getDeleteLink();
        }

        return [
            "pagenew" => $pagenew,
            "pagedetail" => $pagedetail,
            "pageedit" => $pageedit,
            "pagedelete" => $pagedelete,
        ];
    }

    public static function getPaginationParams($resultCount, $params)
    {
        $actualPage = $params['page'];
        $pagenumber = round($resultCount / $params['limit'], 0);
        if ($resultCount % $params['limit'] > 0) {
            $pagenumber ++;
        }
        if ($pagenumber == 0) {
            $pagenumber = 1;
        }

        $breakStart = 0;
        $breakEnd = 0;
        if ($pagenumber > 5) {
            $breakStart = 3;
            $breakEnd = $pagenumber - 2;
        }
        return  [
            "pagenumber" => $pagenumber,
            "breakStart" => $breakStart,
            "breakEnd" => $breakEnd,
            "actualPage" => $actualPage,
        ];
    }

    public static function arrayToChartValue($targets, $key, $value)
    {
        $response = [];
        $response['key'] = [];
        $response['value'] = [];
        $response['color'] = [];
        foreach ($targets as $v) {
            \array_push($response['key'],$v[$key]);
            \array_push($response['value'],$v[$value]);
            \array_push($response['color'],self::generateRandomColor());
        }
        return $response;
    }

    public static function generateRandomColor()
    {
        $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
        return ('#' . $rand);
    }

    public function invokeCompleteName($targetname)
    {
        $value_imploded = GeneralService::getFieldName($targetname);

    }

    public static function invokeExtension($extension_name, $namespace = "App\\Models\\")
    {
        $value_imploded = GeneralService::getFieldName($extension_name);
        $classname = $namespace . $value_imploded;

        return new $classname();
    }

    public static function invokeQuery($extension_name, $namespace = "App\\Models\\")
    {
        $value_imploded = GeneralService::getFieldName($extension_name);
        $queryClass = $value_imploded . "Query";
        $classname = $namespace . $queryClass;

        return new $classname();
    }

    public static function update($targetname, $params)
    {
        $target_id = $targetname . "_id";
        $query = self::invokeQuery($targetname);
        $query->filterByPrimaryKey($params[$target_id]);
        $target = $query->findOne();
        foreach ($params as $key => $param) {
            $funName = "set" . self::getFieldName($key);
            if (\method_exists($target, $funName)) {
                $target->$funName($param);
            }
        }
        $target->save();
        return $target;
    }

    public static function basicTargetFormat($targetname)
    {
        $realName = self::getRealNameOfAlias($targetname);
        $name = "App\\Models\\Map\\" . self::getFieldName($realName) . "TableMap";
        return $name::getFieldNames(TableMap::TYPE_FIELDNAME);
    }

    public static function getAllExtensionValue($target)
    {
        error_log("get extension value");
        $extensionData = [];
        foreach ($target->getListExtension() as $ext) {
            $fonction_name = "get" . self::getFieldName($ext) . "s";
            $collection = $target->$fonction_name();
            $extensionData[$ext] = self::collectionToArray($collection);
        }

        return $extensionData;
    }

    public static function saveFile($brochureFile,$livrable_name,$targetname,$target_id,$directory)
    {  
        $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
        $s3 = new S3Client([
            'version'  => '2006-03-01',
            'region'   => 'us-east-2',
        ]);
        if(!getenv('S3_BUCKET')){
            throw new Exception("Serveur de fichier non trouvé", 1);
        }
        $bucket = getenv('S3_BUCKET');
        $upload = $s3->upload($bucket, $newFilename, fopen($brochureFile->getPathName(), 'rb'), 'public-read');


        $file = new File();

        $file->setTargetId($target_id);
        $file->setTarget($targetname);
        $file->setLink($upload->get('ObjectURL'));
        $file->setLivrableName($livrable_name);
        $file->save();
        return $file;
    }

    public static function getRecursiveFormat($target, &$listData = [], &$listAlreadyFound = [])
    {
        foreach ($listData as $key => $data) {
            if(is_array($data)){
                self::getRecursiveFormat($key, $data, $listAlreadyFound);
                $listData[$key] = $data;
            }else{
                $realData = self::getRealNameOfAlias($data);
                if(self::isKeyId($realData)){
                    $targetname = \str_replace("_id", "",$realData);
                    if($targetname == $key){
                        $listData[$data] = $data;
                        unset($listData[$key]);
                        continue;
                    }
                    if(in_array($targetname, $listAlreadyFound)){
                        unset($listData[$key]);
                        continue;
                    }

                    if(self::isTargetExist($targetname)){
                        $ext_target_format = self::basicTargetFormat($targetname);
                        array_push($listAlreadyFound, $data);
                        unset($listData[$key]);
                        self::getRecursiveFormat($targetname, $ext_target_format, $listAlreadyFound);
                        
                        $listData[$data] = $ext_target_format;
                        
                    }else {
                        $listData[$data] = $data;
                        unset($listData[$key]);
                    }
                }else {
                    $listData[$data] = $data;
                    unset($listData[$key]);
                }
            }
        }
        error_log("+++++++++++++++++++++++");

    }


    public static function getExtensionListFormat($target)
    {
        $fields = [];
        foreach ($target->getListExtension() as $key => $value) {
            $ext = GeneralService::invokeExtension($value);
            $extFields = array_keys($ext->toArray(TableMap::TYPE_FIELDNAME));
            $fields[$value] = $extFields;
        }
        return $fields;
    }

    public static function collectionToArray($collection,$useavailableList = true)
    {
        $response = [];
        foreach ($collection as $key => $child) {
            
            $mychild = $child;
            
            if (!is_array($child)) {
               
                if(method_exists($child,"availableDataToArray") && $useavailableList){
                    $mychild = $child->availableDataToArray(TableMap::TYPE_FIELDNAME);
                }else{
                    if(is_string($child)){
                        $mychild = $child;
                    }else{
                        $mychild = $child->toArray(TableMap::TYPE_FIELDNAME);
                    }

                    
                }
            }
            array_push($response, $mychild);
        }
        return $response;
    }

    public static function isAllParamsThere($table, $isReceived)
    {
        foreach ($waitingFor as $value) {
            if (!array_key_exists($value, $isReceived)) {
                throw new Exception("params key $value not found", 1);
            }
        }
        return;
    }

    

    public static function isTargetOk($params)
    {
        if (!array_key_exists('target', $params)) {
            throw new Exception("Please specify a target", 1);
        }
        
        return self::invokeExtension($params['target']);
    }

    public static function isTargetExist($target)
    {
        
        if (!in_array($target, self::$listTarget)) {
            return false;
        }
        return true;
    }

    public static function getAllReferents() : array
    {
        $users = UtilisateurQuery::create()
        ->find();
        return self::collectionToArray($users);
    }

    public static function getChoice($targetName, $columnName)
    {
        $choice = ChoiceQuery::create()
        ->filterByTarget($targetName)
        ->filterByColumnName($columnName)
        ->select("value")
        ->findOne();

        $values = self::valueToKey(json_decode($choice, true));
        return empty($values)? [] : $values;
    }

    public static function getTargetById($targetName, $target_id)
    {

        $query = self::invokeExtension($targetName . "_query");
        $target = $query->findPk($target_id);
        return $target;
    }

    public static function getCompleteDataOfOneTargetById($targetname, $target_id)
    {
        $target = self::invokeExtension($targetname);
        $query = self::invokeExtension($targetname . "_query");

        if (method_exists($target, "joinOtherColummns")) {
            $target->joinOtherColummns($query);
        }
        
        $target = $query->findPk($target_id);
        if (!$target) {
            return [];
        }
        
        if(is_array($target)){
            return $target;
        }
        $targetData = $target->toArray(TableMap::TYPE_FIELDNAME);
        // $target->staticColumns($targetData);
        if (method_exists($target, "getListExtension")) {
            $extension = self::getAllExtensionValue($target);
            $targetData["ext"] = $extension;
        }
        if (method_exists($target, "getAdditionnalData")) {
            $add = $target->getAdditionnalData($targetData);
            $targetData["others"] = $add;
        }
        return $targetData;
    }

    public static function valueToKey($array)
    {

        $result = [];
        foreach ($array as $key => $value) {
            $result[$value] = $value;
        }
        return $result;
    }

    public static function getRealNameOfAlias($targetAlias)
    {
        if(array_key_exists($targetAlias, self::$alias)){
            return self::$alias[$targetAlias];
        }
        return $targetAlias;
    }

    public function remove_primary_key_from_list($list, $target)
    {
        $pk = $target . "_id";
        if (array_key_exists($pk, $list)) {
            unset($list[$pk]);
        }
    }

    public static function getResults($query, &$params, $targetname,$con=null)
    {
        $name = \strtolower($query->getModelShortName());
        self::removeEmptyFilters($params);
        
        self::addAllFilters($query, $params, $targetname);

        $pager = $query->paginate($params['page'], $params['limit'],$con);
        $resultNumbers = $pager->getNbResults();
        if ($params['limit'] == -1) {
            $pager = $query->paginate($params['page'], $resultNumbers);
        }
        $target = $pager->getResults();
        
        return [
            "count" => $resultNumbers,
            $targetname . "s" => self::collectionToArray($target)
        ];
    }

    public static function removeEmptyFilters(&$params)
    {
       foreach ($params as $key => $value) {
           if(!$value){
               unset($params[$key]);
           }
       }

    }

    public static function addAllFilters(&$query, &$params, $targetname)
    {
        !array_key_exists('page', $params) ? $params['page'] = 1 : null;
        !array_key_exists('limit', $params) ? $params['limit'] = 10 : null;
        !array_key_exists('orderby', $params) ? $params['orderby'] = $targetname . "_id" : null;
        if(!$params['orderby']){
            $params['orderby'] = $targetname . "_id";
        }
        self::configOrderBy($query,$params["orderby"]);
        
        self::addOtherFilters($query, $params);
    }

    public static function configOrderBy(&$query,$key)
    {

        if (strpos($key, "%") === false) {
            $query->orderBy($key, Criteria::DESC);
            return;
        }
        
        $filterPath = explode("%", $key, 2);
        
        $extQueryName = "use" . self::getFieldName($filterPath[0]) . "Query";
        if (!method_exists($query, $extQueryName)) {
            return;
        }
        $extQuery = $query->$extQueryName(null,Criteria::LEFT_JOIN);
        if (strpos($filterPath[1], "%") !== false) {
            self::configOrderBy($query, $filterPath[1]);
        }else{
            $extQuery->orderBy($filterPath[1]);
        }
        $extQuery->endUse();

    }

    public static function getFieldName($extension_name)
    {
        $value_exploded = explode("_", $extension_name);
        foreach ($value_exploded as $key => $value) {
            $value_exploded[$key] = ucfirst($value);
        }
        return \implode("", $value_exploded);
    }

    public static function addOtherFilters(ModelCriteria &$query, $params)
    {
        
        foreach ($params as $key => $value) {
            self::addOneFilter($key, $value, $query);
        }
        if (array_key_exists("columns", $params)) {
            self::invokeOtherColumns($query, $params['columns']);
        }
    }

    public static function addOneFilter($key, $value, ModelCriteria &$query)
    {
        if(!$value) return;
        $isFound = null;
        $isFound = self::addSimpleFilter($key, $value, $query);

        !$isFound ? $isFound = self::addMultipleOrFilter($key, $value, $query) : null;
        !$isFound ? self::addExtFilter($key, $value, $query) : null;
    }

    public static function addSimpleFilter($key, $value, ModelCriteria &$query)
    {
        $nameFunction = "filterBy" . self::getFieldName($key);
        if(!$value){
            return;
        }
        if (!method_exists($query, $nameFunction)) {
            return;
        }
        if (is_array($value)) {
            $critera = self::getCritera(array_key_first($value));
            if ($critera) {
                $data = $value[array_key_first($value)];
                if(!$data) return;
                if (array_key_first($value) == "lk") {
                    $data = "%$data%";
                }
                if(array_key_exists("min",$value) && $value['min']){
                    try {
                        $minDate = date_create($value['min']);
                        $maxDate = date("Y/m/d");
                        if(array_key_exists("max",$value) && $value['max']){
                            $maxDate = date_create($value['max']);
                        }

                        $query->$nameFunction(["min" =>$minDate,"max" => $maxDate]);
                        return;
                    } catch (\Throwable $th) {

                        return;
                    }
                }
                $query->$nameFunction($data, $critera);
            }
            return;
        }
        if (strpos($value, ",")) {
            error_log("multiple data value");
            $value = explode(",", $value);
            $query->$nameFunction($value, Criteria::IN);
            return;
        }
        error_log("array-equals used");
        $query->$nameFunction($value);


        return true;
    }

    public static function addExtFilter($key, $value, ModelCriteria &$query)
    {
        if (strpos($key, "%") === false) {
            return;
        }
        $filterPath = explode("%", $key, 2);
        $extQueryName = "use" . self::getFieldName($filterPath[0]) . "Query";
        if (!method_exists($query, $extQueryName)) {
            return;
        }

        // $extQuery = $query->$extQueryName();
        $extQuery = $query->$extQueryName(null,Criteria::LEFT_JOIN);

        self::addOneFilter($filterPath[1], $value, $extQuery);
        $extQuery->endUse();
    }

    public static function getCritera($criteraByUser)
    {
        $critera = null;
        switch ($criteraByUser) {
            case 'lk':
                $critera = Criteria::LIKE;
                break;
            case 'nlk':
                $critera = Criteria::NOT_LIKE;
                break;
            case 'ne':
                $critera = Criteria::NOT_EQUAL;
                break;
            case 'gt':
                $critera = Criteria::GREATER_THAN;
                break;
            case 'lt':
                $critera = Criteria::LESS_THAN;
                break;
            case 'min':
                $critera = Criteria::EQUAL;
                break;

            default:
                # code...
                break;
        }
        return $critera;
    }

    public static function addMultipleOrFilter($key, $value, ModelCriteria &$query)
    {
        if (strpos($key, ",") === false) {
            return;
        }
        $filterPath = explode(",", $key);
        for ($i = 0; $i < count($filterPath); $i++) {
            self::addOneFilter($filterPath[$i], $value, $query);
            if ($i < \count($filterPath) - 1) {
                $query->_or();
            }
        }
        return true;
    }

    public static function count($list, $key, $value)
    {
        $count = 0;
        foreach ($list as $k => $v) {
            if ($v[$key] == $value) $count++;
        }
        return $count;
    }

    //Check if 2 object is similar and result as similar if difference is an null value for one of them
    public static function isEquals($objet1, $objet2, $keyToIgnore = [])
    {
        $objet1Array = $objet1->toArray();
        $objet2Array = $objet2->toArray();
        foreach ($objet1Array as $key => $value) {
            
            if (\in_array($key, $keyToIgnore)  || !$objet2Array[$key]) {
                continue;
            }
            if (!array_key_exists($key, $objet2Array)) {
                return false;
            }
            if ($objet1Array[$key] != $objet2Array[$key]) { 
                return false;
            }
        }
        return true;
    }

    public static function getResultWithCustomColumns(&$query, $params)
    {
        error_log("get Result With Custom Columns");
        self::addOtherFilters($query, $params);


        $collection = $query->find();
        return $collection;
    }

    public static function invokeOtherColumns(&$query, $columns)
    {
        error_log("invoke other columns");
        if (strpos($columns, ",") === false) {
            self::invokeOneColumn($query, $columns);
            return;
        }

        $listColunmns = explode(",", $columns);
        foreach ($listColunmns as $key => $column) {
            self::invokeOneColumn($query, $column);
        }
    }

    public static function invokeOneColumn(&$query, $columnName, $isExtension = false)
    {
        if (strpos($columnName, "%") === false && !$isExtension) {
            error_log("it's not an additionnal column");
            return;
        }

        $filterPath = explode("%", $columnName, 2);
        $extQueryName = "use" . self::getFieldName($filterPath[0]) . "Query";
        if (!method_exists($query, $extQueryName)) {
            error_log("method $extQueryName not exist,ignore extension");
            return;
        }
        $extQuery = $query->$extQueryName(null, Criteria::LEFT_JOIN);
        if (strpos($filterPath[1], "%")) {
            self::invokeOneColumn($extQuery, $filterPath[1], true);
        } else {
            $column = self::getFieldName($filterPath[0]) . "." . $filterPath[1];
            $column_name = $filterPath[0] . "_" . $filterPath[1];
            $extQuery->withColumn($column, $column_name);
        }
        $extQuery->endUse();
    }

    public static function createPDF(Array $data, $targetName,$folder)
    {
        $date = new \DateTime();
        $filename = $folder. "/" . $targetName . $date->getTimestamp() . ".pdf";
        $mpdf = new Mpdf();
        self::addDataToPDF($data, $mpdf, $targetName);

        $mpdf->Output($filename, 'F');
        $mpdf->Close();
        return $filename;
    }

    public static function addDataToPDF($data, &$mpdf, $targetName)
    {
        $ext = null;
        $others = null;
        $dataHtml = "";
        if (array_key_exists("ext", $data)) {
            $ext = $data['ext'];
            unset($data['ext']);
        }
        if (array_key_exists("others", $data)) {
            $others = $data['others'];
            unset($data['others']);
        }
        $dataHtml .= self::addBasicDataToPDF($data, $mpdf, $targetName);
        $dataHtml .= self::addAdditionnalDataToPDF($others, $mpdf);
        $dataHtml .= self::addAdditionnalDataToPDF($ext, $mpdf, "");
        $mpdf->WriteHTML($dataHtml);
    }

    public static function addBasicDataToPDF($data, &$mpdf, $targetName)
    {
        $dataHtml = sprintf("<h1>Details %s</h1>", self::getFieldName($targetName));
        $dataHtml .= '</br>';

        foreach ($data as $key => $value) {
            if (!self::isKeyId($key)) {
                $dataHtml .= \sprintf("<p><b>%s : </b> %s</p>", $key, $value);
            }

        }
        return $dataHtml;
    }

    public static function addAdditionnalDataToPDF($data, &$mpdf, $title = "Autres informations")
    {
        if (!$data) return;
        $dataHtml = "</hr>";
        $waitingForNextStep = [];
        if (!is_numeric($title)) {
            $dataHtml .= sprintf("<h2>%s</h2>", $title);
        }
        $dataHtml .= "<ul>";
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $waitingForNextStep[$key] = $value;
                continue;
            }
            if (!self::isKeyId($key)) {
                $dataHtml .= sprintf("<li><b> %s :</b> %s</li>", $key, $value);
            }

        }
        $dataHtml .= "</ul>";
        if (!empty($waitingForNextStep)) {

            foreach ($waitingForNextStep as $key => $value) {
                $dataHtml .= self::addAdditionnalDataToPDF($value, $mpdf, $key);
            }
        }

        return $dataHtml;
    }

    public static function isKeyId($key)
    {
        if (strrpos($key, "_id") !== false) {
            return true;
        }
        return false;
    }


    /**
     * Get the value of listTarget
     */ 
    public static function getListTarget()
    {
        return self::$listTarget;
    }
}
