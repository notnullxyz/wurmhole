<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Helper methods and tools that don't belong anywhere.
 *
 * @author Marlon
 */
class Helper {
    
    public function __construct() {
    }
    
    /**
     * A quick augmentation to add NAME to the skills data array. This can be
     * optomised. TODO
     * @param array $skillData
     * @param SkillNumbers $skillNumbers
     * @return array
     */
    public function remapAllSkillsWithNames(array $skillData, SkillNumbers $skillNumbers) : array {
        $augmented = [];
        foreach ($skillData as $value) {
            $skillId = $value['ID'];
            $skillNum = $value['NUMBER'];
            $skillVal = $value['VALUE'];
            $skillName = $skillNumbers->get($skillNum);
            
            $augmented[] = [
                'ID' => $skillId,
                'NUMBER' => $skillNum,
                'NAME' => $skillName,
                'VALUE' => $skillVal
            ];
        }
        return $augmented;
    }
    
    
}
