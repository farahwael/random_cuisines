<?php
/**
 * Created by PhpStorm.
 * User: fwael
 * Date: 11/01/18
 * Time: 02:38 م
 */

class DataProcessing{

    public function readFile($FileName){
        return json_decode(file_get_contents('DataFiles/'.$FileName.'.json'),true);
    }

    public function getIngredientAndProb(){
        $Ingredients = $this->readFile('ingredients');
        $IngrdProbPairs = array();

        foreach ($Ingredients as $k=>$ingredient){
            $IngrdProbPairs[$k]['ingredient_id'] = $ingredient['ingredient_id'];
            $IngrdProbPairs[$k]['frequency_prob'] = $ingredient['frequency_prob'];
        }

        return $IngrdProbPairs;
    }

    public function getIngredients(){
        $Ingredients = $this->readFile('ingredients');
        $IngredientsSet = array();

        foreach ($Ingredients as $k=>$ingredient){
            $IngredientsSet[$k] = $ingredient['ingredient_id'];
        }

        return $IngredientsSet;
    }

    public function getCategoriesMappedWithIngredients($IngredientsInfo){
        $CategoriesIngredients = array();

        foreach ($IngredientsInfo as $Info){
            $CategoriesIngredients[$Info['category_id']][] = $Info['ingredient_id'];
        }

        return $CategoriesIngredients;
    }

    public function getCategoriesMappedWithWeightedIngredients($IngredientsInfo,$RecipeCategoryUsage){
        $CategoriesWeightedIngredients = array();
        $WeightedIngredient=array();
        foreach ($IngredientsInfo as $Info){
            $WeightedIngredient['ingredient_id'] = $Info['ingredient_id'];
            $WeightedIngredient['frequency_prob'] = $Info['frequency_prob'];
            $CategoriesWeightedIngredients[$Info['category_id']][] = $WeightedIngredient;
        }

        foreach ($CategoriesWeightedIngredients as $Category=>$Value){
            if ($RecipeCategoryUsage[$Category]==0){
                unset($CategoriesWeightedIngredients[$Category]);
            }
            for($i=0; $i<$RecipeCategoryUsage[$Category]-1;$i++){
                $CategoriesWeightedIngredients[] = $CategoriesWeightedIngredients[$Category];
            }
        }
        return array_values($CategoriesWeightedIngredients);
    }
}