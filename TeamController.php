<?php

class TeamsController {

    public $types = array('WC', 'ALL','BAT','BOWL');

    protected $A = 'RGD';
    protected $B = 'ASL';

    public $conditions = array(
        'pitch_support' => 'BOWL',
        'match_ower'    => '50', 
        'win_avg'       => 'BAT_FIRST', 
        'winning_strategy' => 'A' 
    );

    public $playersRange = array(
        'WC'    => [1,3],
        'BAT'   => [2,5],
        'ALL'   => [1,4],
        'BOWL'  => [2,5]
    );

    public $captains = array(
        'S Gill',
        'D Warner',
        'M Marsh',
        'R Jadeja',
        'S Smith',
        'J Bumrah',
        'P Cummins',
        'M Stoinis',
        'L Rahul',
        'R Gaikwad'
    );

        public $WC = array(
            1 => 'K Rahul',
            2 => 'J Inglis',
            3 => 'I Kishan'
        );

        public $ALL = array(
            'A' => array(
                1 => 'R Jadeja',
                2 => 'CMC',
            ),
            'B' => array(
                1 => 'M Stoinis',
                2 => 'C Green',
            ),
        );

        public $BAT = array(
                1 => 'S Gill',
                2 => 'R Gaikwad',
                3 => 'S Iyer',
                4 => 'S Yadav',
                5 => 'D Warner',
                6 => 'M Labuschagne',
                7 => 'S Smith',
                8 => 'M Marsh'
            )
        );

        public $BOWL = array(
            'A' => array(
                1 => 'J Bumrah',
                2 => 'M Shami',
            ),
            'B'=> array(
                1 => 'P Cummins',
                2 => 'A Zampa',
                3 => 'M Starc'
            )
        );

        public $dreamCaptains = array();
        public $dreamTeam = array();

    /**
     * Shuffle the team and return the result
     */
    public function getDreamTeam(){
        $this->createTeam();
        $this->fixTeam();
        $this->getCaptain();
        return true;
    }

    protected function createTeam(){
        $this->getBowlers();
        $this->getWC();
        $this->getAllRounders();
        $this->getBatsman();

        return true;
    }

    private function fixTeam(){
        //GET THE PLAYERS COUNT
        $pcount = count($this->dreamTeam['WC']) + count($this->dreamTeam['ALL']) + count($this->dreamTeam['BAT']) + count($this->dreamTeam['BOWL']);
        If($pcount < 11){
            $players_to_add = 11 - $pcount;
            $x = 1;
            while($x <= $players_to_add){
                //ADD BOWLER
                if(count($this->dreamTeam['BOWL']) < 3 && (!empty($this->BOWL['A']) || !empty($this->BOWL['B']))){ 
                    if(empty($this->BOWL['A'])) $team = 'B';
                    if(!empty($this->BOWL['A']) && !empty($this->BOWL['B'])) {
                        $team = $this->getRandomTeam();
                    }
                    $this->dreamTeam['BOWL'][] = current($this->BOWL[$team]);
                    $x++;
                    continue;
                }

                //ADD ALL ROUNDER
                if(count($this->dreamTeam['ALL']) < 3 && (!empty($this->ALL['A']) || !empty($this->ALL['B']))){ 
                    if(empty($this->ALL['A'])) $team = 'B';
                    if(!empty($this->ALL['A']) && !empty($this->ALL['A'])) {
                        $team = $this->getRandomTeam();
                    }
                    $this->dreamTeam['ALL'][] = current($this->ALL[$team]);
                    $x++;
                    continue;
                }

                //ADD BATSMAN
                if(count($this->dreamTeam['BAT']) < 3 && (!empty($this->BAT['A']) || !empty($this->BAT['B']))){
                    $team = (empty($this->BAT['A'])) ? 'B' : 'A';
                    if(!empty($this->BAT['A']) && !empty($this->BAT['B'])) $team = $this->getRandomTeam();
                    $this->dreamTeam['BAT'][] = current($this->BAT[$team]);
                    $x++;
                    continue;
                }
            }
        } else if($pcount > 11){
            $players_to_remove = $pcount - 11;
            $y = 1;
            //ELIMINATE PLAYERS
            while($y <= $players_to_remove){
                if(count($this->dreamTeam['BAT']) >= 4 ){ 
                    array_shift($this->dreamTeam['BAT']);
                    $y++; continue;
                } else if(count($this->dreamTeam['WC']) > 2){ 
                    array_shift($this->dreamTeam['WC']);
                    $y++; continue;
                } else if(count($this->dreamTeam['BOWL']) >= 4){ 
                    array_shift($this->dreamTeam['BOWL']);
                    $y++; continue;
                } else if(count($this->dreamTeam['ALL']) >= 4){ 
                    array_shift($this->dreamTeam['ALL']);
                    $y++; continue;
                } else {
                    break;
                }
            }
        } else {
            return true;
        }
    }

    private function getWC(){
        $total_wcs = rand(2,3);
        $x =1; 
        $reservedNames = array();
        while($x <= $total_wcs) {
            $index = rand(1,count($this->WC));
            if(!in_array($this->WC[$index], $reservedNames)){
                $this->dreamTeam['WC'][] = $this->WC[$index];
                $reservedNames[] = $this->WC[$index];
                unset($this->WC[$index]);
                $x++;
            }
        }
        return true;
    }

    protected function getBatsman(){
        $total_batters = rand(1,2);
        $x = 1;
        $reservedNames = array();
        while($x <= $total_batters) {
            $team = "A";
            if(empty($this->BAT['A']) || empty($this->BAT['B'])) $team = (empty($this->BAT['A'])) ? 'B' : 'A';
            if(!empty($this->BAT['A']) && !empty($this->BAT['B'])) $team = $this->getRandomTeam();

            $keys = array_keys($this->BAT[$team]);
            $index = array_rand($keys,1);
            $key = $keys[$index];
            if(isset($this->BAT[$team][$key]) && !in_array($this->BAT[$team][$key], $reservedNames)){
                $this->dreamTeam['BAT'][] = $this->BAT[$team][$key];
                $reservedNames[] = $this->BAT[$team][$key];
                unset($this->BAT[$team][$key]);
                $x++;
            }
        }
        return true;
    }

    private function getBowlers(){
        $total_bowlers = rand(2,4);
        $reservedNames = array();
        $x = 1;
        while($x <= $total_bowlers) {
            if(empty($this->BOWL['A']) && empty($this->BOWL['B'])) break;
            if(empty($this->BOWL['A'])) $team = 'B';
            if(!empty($this->BOWL['A']) && !empty($this->BOWL['B'])) $team = $this->getRandomTeam();
            if($x == 1) $team = 'A';
            if($x == 2) $team = 'B';  
            
            if(empty($this->BOWL[$team])) continue;
            $index = rand(1,count($this->BOWL[$team]));
            if(isset($this->BOWL[$team][$index]) && !empty($team) && !in_array($this->BOWL[$team][$index], $reservedNames)){
                $this->dreamTeam['BOWL'][] = $this->BOWL[$team][$index];
                $reservedNames[] = $this->BOWL[$team][$index];
                $this->BOWL[$team][$index] = NULL;
                $x++;
            }
        }
    }

    protected function getAllRounders(){
        $total_allrounders = rand(3,5);
        $x =1; $team = "";
        $reservedNames = array();
        while($x <= $total_allrounders) {
            $team = "A";
            if(empty($this->ALL['A']) || empty($this->ALL['B'])) $team = (empty($this->ALL['A'])) ? 'B' : 'A';
            if(!empty($this->ALL['A']) && !empty($this->ALL['B'])) $team = $this->getRandomTeam();
            $keys = array_keys($this->ALL[$team]);
            $index = array_rand($keys,1);
            $key = $keys[$index];
            if(isset($this->ALL[$team][$key]) && !in_array($this->ALL[$team][$key], $reservedNames)){
                $this->dreamTeam['ALL'][] = $this->ALL[$team][$key];
                $reservedNames[] = $this->ALL[$team][$key];
                unset($this->ALL[$team][$key]);
                $x++;
            }
        }
        return true;
    }

    protected function getCaptain(){
        $i = 1;
        do {
            $type = $this->getRandomTypes();
            $keys = array_keys($this->dreamTeam[$type]);
            $index = array_rand($keys,1);
            $key = $keys[$index];
            if(!isset($this->dreamCaptains['captain']) && in_array($this->dreamTeam[$type][$key], $this->captains)) {
                $this->dreamCaptains['captain'] = $this->dreamTeam[$type][$key];
                $i++;
                continue;

            } 
            if(!isset($this->dreamCaptains['vice_captain']) && in_array($this->dreamTeam[$type][$key], $this->captains)) {
                $this->dreamCaptains['vice_captain'] = $this->dreamTeam[$type][$key];
                $i++;
                continue;
            }
        } while($i <= 2);
        return true;
    }

    private function getRandomTeam(){
        $t = 'A';
        $rand = rand(1,10);
        if($rand % 2 == 0) $t = 'B';
        return $t;
    }

    private function getRandomTypes(){
        $keys = array_keys($this->types);
        $index = array_rand($keys,1);
        $key = $keys[$index];
        return $this->types[$key];
    }

}

$team = new TeamsController;
$team->getDreamTeam();