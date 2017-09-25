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
    
    private $skillNumberMapper;
    
    public function __construct(SkillNumbers $sn) {
        $this->skillNumberMapper = $sn;
    }
    
    /**
     * A quick augmentation to add NAME to the skills data array. This can be
     * optimised. TODO
     * @param array $skillData
     * @param SkillNumbers $skillNumbers
     * @return array
     */
    public function remapAllSkillsWithNames(array $skillData) : array {
        $augmented = [];
        foreach ($skillData as $value) {
            $skillId = $value['ID'];
            $skillNum = $value['NUMBER'];
            $skillVal = $value['VALUE'];
            $skillName = $this->skillNumberMapper->get($skillNum);
            
            $augmented[] = [
                'ID' => $skillId,
                'NUMBER' => $skillNum,
                'NAME' => $skillName,
                'VALUE' => $skillVal
            ];
        }
        return $augmented;
    }
    
    /**
     * Retrieve and return the internal skill name, given a pretty skill name from the player skills dump files.
     */
    public function getInternalSkillNameByPrettyName(string $prettySkillName) {
        return $this->skillNumberMapper->getInternalNameByPrettyName($prettySkillName);
    }
    
    
}
