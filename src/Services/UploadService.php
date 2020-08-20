<?php
namespace App\Services;

use DateTime;
use Exception;
use App\Models\Import;
use Propel\Runtime\Propel;
use App\Models\ImportQuery;
use App\Models\Map\OscTableMap;
use App\Models\UtilisateurQuery;
use App\Services\GeneralService;
use Propel\Runtime\Map\TableMap;
use App\Models\Map\EmployeTableMap;
use PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;


class UploadService
{
    private $filename;
    private $listReference;

    public function __construct()
    {
        $this->listMapping = [];
        $this->target_dir = getenv("MEDIA_FOLDER");
        $this->con =  Propel::getWriteConnection(EmployeTableMap::DATABASE_NAME);
    }

    public function importFile($filename, $target, $worksheet,Array $listReference = [])
    {
        error_log('import file');
        $this->listReference = $listReference;
        $this->filename = $filename;
        $this->beginMapping($target, $worksheet);
        
        return [
            "status"  => "success",
        ];
    }

    public function beginMapping($target, $worksheet)
    {
        error_log("begin mapping pointage");
        
        $memberMapping = $this->getImportListMapping($target);
        $dataInWorkSheet = $this->loadSheetData($worksheet);
        $this->mapOneExtension($dataInWorkSheet,$memberMapping[0], $target);
        
    }

    public function getImportListMapping($target)
    {
        $query = ImportQuery::create();
        $query->filterByTarget($target);
        $results = $query->find();
        if(!count($results)){
            throw new Exception("Table de mapping non trouvé dans la base", 1);
        }
        return GeneralService::collectionToArray($results);
    }

    public function loadSheetData($worksheet = "Identification")
    {
        $spreadsheet = IOFactory::load($this->filename);
        $data = $spreadsheet->getSheetByName($worksheet);
        if(!$data){
            throw new Exception("Worksheet '$worksheet'not found", 1);
        }
        return $data;
    }

    public function mapOneExtension($data,$map, $target)
    {
        $mapping = json_decode($map['mapping'], true);
        
        if(array_key_exists("boucle",$mapping)){
            $this->mapLoopData($data,$map,$target);
        }else{
            $this->mapFixedData($data,$map);
        }
    }

    public function mapLoopData($data,$map,$target)
    {
        error_log("map loop data");
        $found = true;
        $mapping = json_decode($map['mapping'], true);
        $indicator = $mapping["boucle"];
        $keys = $this->getAllKeys($mapping['data'][0]);
        $sql = $this->createBaseInsertSql($mapping['data'][0],$target, $keys);

        
        $listLine = [];
        $lastInserted = GeneralService::invokeExtension($map["target"]);
        while ($found) {
            error_log($indicator);
            $extTarget = GeneralService::invokeExtension($map["target"]);
            $oneMapper = $this->createOneLoopMapper($mapping['data'],$indicator);
            try {
                $countInserted = $this->mapOneRow($data,$extTarget, $oneMapper);
                if(!$countInserted){
                    $found = false;
                    break;
                }
                $this->addLine($listLine, $extTarget, $keys);
                $lastInserted = $extTarget->copy();
                $indicator++;
            } catch (\Throwable $th) {
                $indicator++;
            }
        }
        $sql .= implode(",", $listLine );

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
    }

    public function addLine(&$listLine, $target,$keys)
    {
        $array = $target->toArray(TableMap::TYPE_FIELDNAME);

        $results = [];
        foreach ($keys as $key) {
            $getter = "get" . GeneralService::getFieldName($key);
            
            $data = null;
            if (method_exists($target, $getter)) {
                $data = $target->$getter();
                if ($data instanceof \DateTimeInterface) {
                    $data = date_format($data, 'Y-m-d H:i:s');
                }
            }
            array_push($results,$data);

        }
        $line = sprintf("'%s'", implode("','", $results ) );
        array_push($listLine, sprintf("(%s)",$line));
    }

    public function createBaseInsertSql($data,$target, $keys)
    {   
        $keylines = implode(",", $keys );
        return "INSERT INTO $target ($keylines) VALUES ";
    }

    public function getAllKeys($keys)
    {
        $result = [];

        foreach ($keys as $key => $value) {
            $k = $key;
            if(strpos($key,"%") !== false){
                $array = explode("%", $key, 2);
                $k = $array[0];
            }
            array_push($result,$k);
        }
        return $result;
    }

    public function mapOneRow($data,$target, $arrayData)
    {
        $countValueInserted = 0;
        foreach ($arrayData as $column => $reference) {
            $isSwitchedColumn = strpos($column,"%") ;
            $value = $data->getCell($reference)->getFormattedValue();

            if($isSwitchedColumn !== false){
                $array = explode("%", $column, 2);
                $column = $array[0];
                $value = $this->getRealValue($value,$array);
            }
            $setterFunction = "set" . GeneralService::getFieldName($column);
            if(method_exists($target,$setterFunction)){
                if (strpos($column, 'date') !== false) {
                    try {
                        $date = DateTime::createFromFormat('d/m/Y H:i:s',$value );

                        $value = $date;
                    } catch (\Throwable $th) {
                        error_log($th);
                    }
                }
                if($value){
                    $target->$setterFunction($value);
                    $countValueInserted++;
                }
            }
        }
        
        return $countValueInserted;
    }

    public function getRealValue($toFind, $keyArray)
    {
        foreach ($this->listReference as $key => $ref) {
            if($ref[$keyArray[1]] == $toFind){
                return $ref[$keyArray[0]];
            }
        }
        return null;
    }

    public function createOneLoopMapper($data,$indicator)
    {
        $data = $data;
        $oneMapper = [];
        foreach ($data[0] as $key => $oneColumn) {
            $oneMapper[$key] = $oneColumn . $indicator;
        }
        return $oneMapper;
    }

    public function mapFixedData($data,$map)
    {
        $mapping = json_decode($map['mapping'], true);
        $lastInserted = GeneralService::invokeExtension($map["target"]);
        foreach ($mapping as $key => $oneMapper) {
            $extTarget = GeneralService::invokeExtension($map["target"]);
            $countInserted = $this->mapOneRow($data,$extTarget, $oneMapper);
            if(!$countInserted){
                error_log("no value inserted - SKIP");
                continue;
            }
            $toSkip = ["OscId", $map["target"]."Id"];
            if(GeneralService::isEquals($lastInserted,$extTarget,$toSkip)){
                error_log("duplicate with de last insertion");
                continue;
            }
            $lastInserted = $extTarget->copy();
            $this->addAdditionnalData($extTarget,$map["target"]);

            if(method_exists($extTarget,"setOscId")){
                $extTarget->setOscId($this->basicTarget->getOscId());
            }
            $extTarget->save($this->con);
            
        }
    }

}