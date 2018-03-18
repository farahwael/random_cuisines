<?php
/**
 * Created by PhpStorm.
 * User: fwael
 * Date: 11/01/18
 * Time: 12:04 ص
 */

class Probability
{

    public $recipesCount=400;

    public function getRandomElement($array)
    {
        return $array[array_rand($array)];
    }

    public function getRandomElementWeightedProb($array)
    {
        $weightsSum = 0;
        for($i=0; $i<count($array); $i++){
            $weightsSum+=$array[$i]['frequency_prob'];
        }

        $rand = mt_rand(0,$weightsSum);

        for($i=0; $i<count($array); $i++){
            if ($rand <= $array[$i]['frequency_prob'])
                return $i;
            $rand -= $array[$i]['frequency_prob'];
        }
    }

}


4 — 6
2 — 3
1 — 1

Sum = 10
rand = 4

1222444444
