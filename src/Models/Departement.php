<?php

namespace App\Models;

use App\Services\GeneralService;
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

    private $addmore = true;

    public function getAddmore()
    {
        return $this->addmore;
    }

    public function getTitle()
    {
        return "Département";
    }

    public function joinOtherColummns(&$query)
    {
        $query
            ->useDirectionQuery()
            ->withColumn('Direction.designation', 'direction')
            ->endUse();
    }


    public function keyCrud()
    {
        $direction = GeneralService::getTargetAsChoice('direction','designation');
        return [
            
            [
                "path" => "designation",
                "key" => "Désignation"
            ],
            [
                "path" => "description",
                "key" => "Déscription"
            ],[
                "path" => "direction_id",
                "key" => "Direction",
                "value" => $direction,
                "type" => 'select',
            ]
            ];
    }

    public function getKeySearch()
    {
        $direction = GeneralService::getTargetAsChoice('direction','designation');
        return [
            [
                "path" => "designation",
                "key" => "designation",
            ],[
                "path" => "direction_id",
                "key" => "Direction",
                "value" => $direction,
                "type" => 'select',
            ]
        ];
    }

    private $keyToShow =[
        "designation","direction", "description"
   ];

   private $keyText = [
       "Désignation",
       "Direction",
       "Description"

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
