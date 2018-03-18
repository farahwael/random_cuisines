<?php

/**
 * Created by PhpStorm.
 * User: fwael
 * Date: 11/01/18
 * Time: 02:51 م
 */

class Recipe {

    private $DataProcessingObj;
    private $ProbabilityObj;
    private $minRecipeSize=3;
    private $maxRecipeSize=26;

    public function __construct()
    {
        $this->DataProcessingObj = new DataProcessing();
        $this->ProbabilityObj = new Probability();
    }

    //(A,B)
    private function getFrequencyConservingRecipe(){

        $RecipeIngredients = array();
        $IngredientsArray = $this->DataProcessingObj->getIngredientAndProb();
        $recipeSize=$this->getRecipeSize();

        for($i=0; $i<$recipeSize; $i++){
            $RecipeIngredients[] = $this->ProbabilityObj->getRandomElementWeightedProb($IngredientsArray);
        }

        return $RecipeIngredients;
    }

    //(C,D)
    private function getFreqCategoryConservingRecipe($RecipeIndex){
        $RecipeIngredients = array();
        $AllRecipesCategoryUsage = $this->DataProcessingObj->readFile('category_usage');
        $RecipeCategoryUsage = $AllRecipesCategoryUsage[$RecipeIndex];
        $RecipeSize = $this->getCategoryConservingRecipeSize($RecipeCategoryUsage);

        $IngredientsInfo = $this->DataProcessingObj->readFile('ingredients');
        $CategoriesWeightedIngredients = $this->DataProcessingObj->getCategoriesMappedWithWeightedIngredients($IngredientsInfo,$RecipeCategoryUsage);

        for($i=0; $i<$RecipeSize; $i++){
            $randomElement = $this->ProbabilityObj->getRandomElement($CategoriesWeightedIngredients[1]);
            $RecipeIngredients[$i] = $randomElement['ingredient_id'];
        }

        return $RecipeIngredients;
    }

    //(E,F)
    private function getUniformRandomRecipe(){

        $RecipeIngredients = array();
        $IngredientsArray = $this->DataProcessingObj->getIngredients();
        $recipeSize=$this->getRecipeSize();

        for($i=0; $i<$recipeSize; $i++){
            $randIngrd = $this->ProbabilityObj->getRandomElement($IngredientsArray);
            while(in_array($randIngrd,$RecipeIngredients)
            {
                $randIngrd = $this->ProbabilityObj->getRandomElement($IngredientsArray);
            }
            $RecipeIngredients[]  = $randIngrd;
        }

        return $RecipeIngredients;
    }

    //(G,H)
    private function getUniformRandomCategoryConservingRecipe($RecipeIndex){

        $RecipeIngredients = array();
        $AllRecipesCategoryUsage = $this->DataProcessingObj->readFile('category_usage');
        $RecipeCategoryUsage = $AllRecipesCategoryUsage[$RecipeIndex];
        $RecipeSize = $this->getCategoryConservingRecipeSize($RecipeCategoryUsage);

        $IngredientsInfo = $this->DataProcessingObj->readFile('ingredients');
        $CategoriesIngredients = $this->DataProcessingObj->getCategoriesMappedWithIngredients($IngredientsInfo);
        for($i=0; $i<$RecipeSize; $i++){
            $RecipeIngredients[$i] = $this->ProbabilityObj->getRandomElement($CategoriesIngredients[1]);
        }

        return $RecipeIngredients;
    }

    public function getRecipe($TypesParams,$RecipeIndex=0){
        $CategoryConserving=false;
        $FreqConserving=false;

        if (isset($TypesParams['category_cons']) && $TypesParams['category_cons'])
            $CategoryConserving=true;

        if (isset($TypesParams['freq_cons']) && $TypesParams['freq_cons'])
            $FreqConserving=true;

        if ($FreqConserving){
            if ($CategoryConserving) //getCategoryFreqConserving (C,D)
                return $this->getFreqCategoryConservingRecipe($RecipeIndex);
            else //getFreqConserving (A,B)
                return $this->getFrequencyConservingRecipe();
        }else{
            if ($CategoryConserving) //getCategoryConserving (G,H)
                return $this->getUniformRandomCategoryConservingRecipe($RecipeIndex);
            else //get UniformRandom (E,F)
                return $this->getUniformRandomRecipe();
        }

    }

    private function getRecipeSize(){
        return mt_rand($this->minRecipeSize,$this->maxRecipeSize);
    }

    private function getCategoryConservingRecipeSize($CategoryUsage){
        $RecipeSize=0;
        foreach ($CategoryUsage as $count){
            $RecipeSize+=$count;
        }
        return $RecipeSize;
    }

}