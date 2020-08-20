<?php

namespace App\Models;

use App\Models\Base\DepartementQuery;
use App\Models\Base\Departement as BaseDepartement;

/**
 * Skeleton subclass for representing a row from the 'departement' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Departement extends BaseDepartement
{

    public function getAllDepartmentAsChoice()
    {
        $query = DepartementQuery::create()
        ->withColumn("departement_id")
        ->withColumn("designation")

        ->orderBy("designation")
        ->select("departement_id","designation");

        
        $referents = $query->find();

        $response = [];
        foreach ($referents as $key => $child) {
            $k = $child['designation'];

            $response[$k] = $child['departement_id'];
        }
        
        return $response;
    }
}
