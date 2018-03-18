<?php
/**
 * Created by PhpStorm.
 * User: fwael
 * Date: 11/01/18
 * Time: 02:39 م
 */

class RandomCuisine {

    private $CuisineSize=400;

    public function getCuisine($CuisineType){

        $RecipeType=array('category_cons'=>0, 'freq_cons'=>0);

        switch ($CuisineType){
            case 'frequency-conserving':
                $RecipeType=array('category_cons'=>0, 'freq_cons'=>1);
                break;
            case 'frequency-category-preserving':
                $RecipeType=array('category_cons'=>1, 'freq_cons'=>1);
                break;
            case 'uniform-random':
                $RecipeType=array('category_cons'=>0, 'freq_cons'=>0);
                break;
            case 'uniform-random-category-preserving':
                $RecipeType=array('category_cons'=>1, 'freq_cons'=>0);
                break;
        }

        $CuisineRecipes = array();
        $Recipe = new Recipe();
        for($i=0; $i<$this->CuisineSize; $i++){
            $CuisineRecipes[] = $Recipe->getRecipe($RecipeType);
        }

        return $CuisineRecipes;
    }
}