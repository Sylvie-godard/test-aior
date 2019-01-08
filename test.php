<?php

class Point {

    public $id = null; 
    public $x = null;
    public $y = null;

    public function __construct($id, $y, $x){
          $this->id = $id;  
          $this->x = $x;  
          $this->y = $y;  
    }
}


class Agart {
    public $time = 100000;
    public $x = 0;
    public $y = 0;
    public $id = null;
    public $point;

    public function setPoint($point){
        $this->point = $point;
    }

    public function distance(){
        $tab = [];
        $currentPoint = null;
        $currentDist = null;
        foreach($this->point as $p){
            $dx = abs($p->x - $this->x);
            $dy = abs($p->y - $this->y);
            $dist = sqrt($dx ** 2 + $dy ** 2);
            // $tab[] = [$p, $dist];
            if($currentDist == null){
                $currentDist = $dist;
                $currentPoint = $p;
            }else if($dist < $currentDist){
                $currentDist = $dist;
                $currentPoint = $p;
            }
        }
        return [$currentDist, $currentPoint];
    }

    public function go($point, $dist){
        $this->x = $point->x;
        $this->y = $point->y;
        $this->id = $point->id;
        $this->time -= $dist;
    }

    public function deletePoint($id){
        foreach($this->point as $p){
            if($p->id == $id){
                unset($p->x);
                unset($p->y);
                unset($p->id);
                return true;
            }
        }
    }


    private function findPoint($id){
        foreach($this->point as $p){
            if($p->id == $id){
                return $p;
            }
        }
    }

    public function execute($point){
        $this->setPoint($point);
        foreach($this->point as $p){
            $newPoint = $this->distance();
            $this->go($newPoint[1], $newPoint[0]);
            $this->deletePoint($this->id);

            if($this->time <= 0){
                return;
            }
            echo $this->id."\n";
        }
        
    }
}

$lines = file('input_2.txt');
$tab = [];

foreach($lines as $line) {
    $var = explode(",", $line);
    $id = $var[0];
    $x = $var[1];
    $y = $var[2];
    $tab[] = new Point($id, $x, $y);
}

$agar = new Agart();

$agar->execute($tab);
?> 