<?php
/**
 * Created by PhpStorm.
 * User: fwael
 * Date: 10/01/18
 * Time: 06:18 م
 */
require_once 'libraries_loader.php';


$RandomCuisine = new RandomCuisine();
$RandomCuisines = array();

//(A, B) Frequency-conserving
$RandomCuisines['frequency-conserving'] = $RandomCuisine->getCuisine('frequency-conserving');

//(C, D) Frequency and ingredient category preserving
$RandomCuisines['frequency-category-preserving'] = $RandomCuisine->getCuisine('frequency-category-preserving');

//(E, F) Uniform random
$RandomCuisines['uniform-random'] = $RandomCuisine->getCuisine('uniform-random');

//(G, H) Uniform random, ingredient category preserving
$RandomCuisines['uniform-random-category-preserving'] = $RandomCuisine->getCuisine('uniform-random-category-preserving');

foreach ($RandomCuisines as $cuisineType => $randomCuisine){
    $RandomCuisineFile = fopen("DataFiles/Results/".$cuisineType.".json", "w") or die("Unable to open file!");
    fwrite($RandomCuisineFile, json_encode($randomCuisine,JSON_PRETTY_PRINT));
    fclose($RandomCuisineFile);
}


print "Random Cuisines Generated\n";


