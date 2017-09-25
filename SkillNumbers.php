<?php

/**
 * Class SkillNumbers
 * The wurm database for SKILLS does not contain references to the skillnames, just magic numbers.
 * This class is a last-resort effort at resolving them, hoping they won't change in code.
 */
class SkillNumbers {

    /**
     * This array is a wurmhole representation of the following:
     * key: Wurm database skill number
     * values: (the internal skill names used in the Wurm code, the pretty names used in skill dumps)
     * 
     * You've been warned.
     * I do not like or agree with this, but it is how it is. 
     * Do not rely on this data not to change, and do not rely on case.
     * 
     * @var array
     */
    private $skills = [
        
        // Characteristics is a MAIN branch, which contains BODY, SOUL, MIND as follows:
        2147483646 => array('CHARACTERISTICS', 'Characteristics'),
        
        // BODY parent
        1 => array('BODY', 'Body'),
        
        //BODY children
        102 => array('BODY_STRENGTH', 'Body strength'),
        103 => array('BODY_STAMINA', 'Body stamina'),
        104 => array('BODY_CONTROL', 'Body control'),
        
        // MIND parent
        2 => array('MIND', 'Mind'),
        
        // MIND children
        100 => array('MIND_LOGICAL', 'Mind logic'),
        101 => array('MIND_SPEED', 'Mind speed'),
                
        // SOUL parent
        3 => array('SOUL', 'Soul'),

        // SOUL children
        105 => array('SOUL_STRENGTH', 'Soul strength'),
        106 => array('SOUL_DEPTH', 'Soul depth'),

        // RELIGION is a MAIN branch, which contains FAITH, FAVOUR and ALIGNMENT as follows
        2147483643 => array('RELIGION', 'Religion'),
        
        // Religion main branch's subs:
        2147483645 => array('FAITH' , 'Faith'),
        2147483644 => array('FAVOR' , 'Favor'),
        2147483642 => array('ALIGNMENT', 'Alignment'),


        // From here, things have a bit more sanity.
        // Most of these seems to reside under the 'Skills' parent.

        1000 => array('GROUP_SWORDS', 'Swords'),
        1001 => array('GROUP_KNIVES', 'Knives'),
        1002 => array('GROUP_SHIELDS', 'Shields'),
        1003 => array('GROUP_AXES', 'Axes'),
        1004 => array('GROUP_MAULS', 'Mauls'),
        1005 => array('CARPENTRY', 'Carpentry'),
        1007 => array('WOODCUTTING', 'Woodcutting'),
        1008 => array('MINING', 'Mining'),
        1009 => array('DIGGING', 'Digging'),
        1010 => array('FIREMAKING', 'Firemaking'),
        1011 => array('POTTERY', 'Pottery'),
        1012 => array('GROUP_TAILORING', 'Tailoring'),
        1013 => array('MASONRY', 'Masonry'),
        1014 => array('ROPEMAKING', 'Ropemaking'),
        1015 => array('GROUP_SMITHING', 'Smithing'),
        1016 => array('GROUP_SMITHING_WEAPONSMITHING', 'Weapon smithing'),
        1017 => array('GROUP_SMITHING_ARMOURSMITHING', 'Armour smithing'),
        1018 => array('GROUP_COOKING', 'Cooking'),
        1019 => array('GROUP_NATURE', 'Nature'),
        1020 => array('MISCELLANEOUS', 'Miscellaneous items'),
        1021 => array('GROUP_ALCHEMY', 'Alchemy'),
        1022 => array('GROUP_TOYS', 'Toys'),
        1023 => array('GROUP_FIGHTING', 'Fighting'),
        1024 => array('GROUP_HEALING', 'Healing'),
        1025 => array('GROUP_CLUBS', 'Clubs'),
        1026 => array('GROUP_RELIGION', 'Religion'),
        1027 => array('GROUP_HAMMERS', 'Hammers'),
        1028 => array('GROUP_THIEVERY', 'Thievery'),
        1029 => array('GROUP_WARMACHINES', 'War machines'),
        1030 => array('GROUP_ARCHERY', 'Archery'),
        1031 => array('GROUP_BOWYERY', 'Bowyery'),
        1032 => array('GROUP_FLETCHING', 'Fletching'),
        1033 => array('GROUP_POLEARMS', 'Polearms'),
        10001 => array('AXE_SMALL', 'Small Axe'),
        10002 => array('SHOVEL', 'Shovel'),
        10003 => array('HATCHET', 'Hatchet'),
        10004 => array('RAKE', 'Rake'),
        10005 => array('SWORD_LONG', 'Longsword'),
        10006 => array('SHIELD_MEDIUM_METAL', 'Medium metal shield'),
        10007 => array('KNIFE_CARVING', 'Carving knife'),
        10008 => array('SAW', 'Saw'),
        10009 => array('PICKAXE', 'Pickaxe'),
        10010 => array('SMITHING_WEAPON_BLADES', 'Blades smithing'),
        10011 => array('SMITHING_WEAPON_HEADS', 'Weapon heads smithing'),
        10012 => array('SMITHING_ARMOUR_CHAIN', 'Chain armour smithing'),
        10013 => array('SMITHING_ARMOUR_PLATE', 'Plate armour smithing'),
        10014 => array('SMITHING_SHIELDS', 'Shield smithing'),
        10015 => array('SMITHING_BLACKSMITHING', 'Blacksmithing'),
        10016 => array('CLOTHTAILORING', 'Cloth tailoring'),
        10017 => array('LEATHERWORKING', 'Leatherworking'),
        10018 => array('TRACKING', 'Tracking'),
        10019 => array('SHIELD_SMALL_WOOD', 'Small wooden shield'),
        10020 => array('SHIELD_MEDIUM_WOOD', 'Medium wooden shield'),
        10021 => array('SHIELD_LARGE_WOOD', 'Large wooden shield'),
        10022 => array('SHIELD_SMALL_METAL', 'Small metal shield'),
        10023 => array('SHIELD_LARGE_METAL', 'Large metal shield'),
        10024 => array('AXE_LARGE', 'Large axe'),
        10025 => array('AXE_HUGE', 'Huge axe'),
        10026 => array('HAMMER', 'Hammer'),
        10027 => array('SWORD_SHORT', 'Shortsword'),
        10028 => array('SWORD_TWOHANDED', 'Two handed sword'),
        10029 => array('KNIFE_BUTCHERING', 'Butchering knife'),
        10030 => array('STONE_CHISEL', 'Stone chisel'),
        10031 => array('PAVING', 'Paving'),
        10032 => array('PROSPECT', 'Prospecting'),
        10033 => array('FISHING', 'Fishing'),
        10034 => array('SMITHING_LOCKSMITHING', 'Locksmithing'),
        10035 => array('REPAIR', 'Repairing'),
        10036 => array('COALING', 'Coal-making'),
        10037 => array('COOKING_DAIRIES', 'Dairy food making'),
        10038 => array('COOKING_STEAKING', ''),                         // @todo
        10039 => array('COOKING_BAKING', 'Baking'),
        10040 => array('MILLING', 'Milling'),
        10041 => array('SMITHING_METALLURGY', 'Metallurgy'),
        10042 => array('ALCHEMY_NATURAL', 'Natural substances'),
        10043 => array('SMITHING_GOLDSMITHING', ''),                    // @todo
        10044 => array('CARPENTRY_FINE', 'Fine carpentry'),
        10045 => array('GARDENING', 'Gardening'),
        10046 => array('SICKLE', 'Sickle'),
        10047 => array('SCYTHE', 'Scythe'),
        10048 => array('FORESTRY', 'Forestry'),
        10049 => array('FARMING', 'Farming'),
        10050 => array('YOYO', 'Yoyo'),
        10051 => array('TOYMAKING', 'Toy making'),
        10052 => array('WEAPONLESS_FIGHTING', 'Weaponless fighting'),
        10053 => array('FIGHT_AGGRESSIVESTYLE', 'Aggressive fighting'),
        10054 => array('FIGHT_DEFENSIVESTYLE', 'Defensive fighting'),
        10055 => array('FIGHT_NORMALSTYLE', 'Normal fighting'),
        10056 => array('FIRSTAID', 'First aid'),
        10057 => array('TAUNTING', 'Taunting'),
        10058 => array('SHIELDBASHING', 'Shield bashing'),
        10059 => array('BUTCHERING', 'Butchering'),
        10060 => array('MILKING', 'Milking'),
        10061 => array('MAUL_LARGE', 'Large maul'),
        10062 => array('MAUL_MEDIUM', 'Medium maul'),
        10063 => array('MAUL_SMALL', 'Small maul'),
        10064 => array('CLUB_HUGE', 'Huge club'),
        10065 => array('PREACHING', 'Preaching'),
        10066 => array('PRAYER', 'Prayer'),
        10067 => array('CHANNELING', 'Channeling'),
        10068 => array('EXORCISM', 'Exorcism'),
        10069 => array('ARTIFACTS', 'Artifacts'),
        10070 => array('WARHAMMER', 'Warhammer'),
        10071 => array('FORAGING', 'Foraging'),
        10072 => array('BOTANIZING', 'Botanizing'),
        10073 => array('CLIMBING', 'Climbing'),
        10074 => array('STONECUTTING', 'Stone cutting'),
        10075 => array('STEALING', 'Stealing'),
        10076 => array('LOCKPICKING', 'Lock picking'),
        10077 => array('CATAPULT', 'Catapults'),
        10078 => array('TAMEANIMAL', 'Animal taming'),
        10079 => array('BOW_SHORT', 'Short bow'),
        10080 => array('BOW_MEDIUM', 'Medium bow'),
        10081 => array('BOW_LONG', 'Long bow'),
        10082 => array('SHIPBUILDING', 'Ship building'),
        10083 => array('COOKING_BEVERAGES', 'Beverages'),
        10084 => array('TRAPS', 'Traps'),
        10085 => array('BREEDING', 'Animal husbandry'),
        10086 => array('MEDITATING', 'Meditating'),
        10087 => array('PUPPETEERING', 'Puppeteering'),
        10088 => array('SPEAR_LONG', 'Long spear'),
        10089 => array('HALBERD', 'Halberd'),
        10090 => array('STAFF', 'Staff'),
        10091 => array('PAPYRUSMAKING', 'Papyrusmaking'),
        10092 => array('THATCHING', 'Thatching'),
        10093 => array('BALLISTA', 'Ballistae'),
        10094 => array('TREBUCHET', 'Trebuchets'),

        10095 => array('PEWPEWDIE', 'Turrets'), // turrets - according to @see https://forum.wurmonline.com/index.php?/topic/133161-wusi-wurm-unlimited-skills-import/
        
        // Unknowns
        0 => array('TYPE_BASIC', ''),
        1 => array('TYPE_MEMORY', ''),
        2 => array('TYPE_ENHANCING', ''),
        4 => array('TYPE_NORMAL', '')
    ];

    public function __construct() {

    }

    /**
     * Get skill internal name by id/skill-number.
     * @param int $id
     * @return null|string
     */
    public function get(int $id) {
        if (array_key_exists($id, $this->skills)) {
            return (string)strtolower($this->skills[$id][0]);
        }
        return null;
    }
    
    /**
     * Return the internal name, provided the pretty name exists and mapped to it.
     * @param string $prettyName
     * return null|string
     */
    public function getInternalNameByPrettyName(string $prettyName) {
        foreach ($this->skills as $skillNum => $skillNames) {
            if ($skillNames[1] == $prettyName) {
                return $skillNames[0];
            }
        }
        return null;
    }

}