<?php

namespace App\Models;

use App\Models\Base\Direction as BaseDirection;

/**
 * Skeleton subclass for representing a row from the 'direction' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class Direction extends BaseDirection
{
    private $addmore = true;
    public function getAddmore()
    {
        return $this->addmore;
    }

    public function getTitle()
    {
        return "Direction";
    }

    public function keyCrud()
    {
        return [
            
            [
                "path" => "designation",
                "key" => "Désignation"
            ],
            [
                "path" => "description",
                "key" => "Déscription"
            ]
            ];
    }

    public function getKeySearch()
    {
        return [
            [
                "path" => "designation",
                "key" => "designation",
            ]
        ];
    }

    private $keyToShow =[
        "designation", "description"
   ];

   private $keyText = [
       "Désignation",
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
