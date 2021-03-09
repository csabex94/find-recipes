<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Recipe {
    function __construct($id, $title, $servings, $image, $readyIn, $sourceTitle, $sourceUrl, $healthScore, $glutenFree) {
        $this->id = $id;
        $this->title = $title;
        $this->servings = $servings;
        $this->readyIn = $readyIn;
        $this->sourceTitle = $sourceTitle;
        $this->sourceUrl = $sourceUrl;
        $this->healthScore = $healthScore;
        $this->glutenFree = $glutenFree;
        $this->image = $image;
    }
}

class AutoCompleteHandler extends Component
{
    public $searchQuery = "";
    public $selectedToHighlight = 0;
    public $searchResult = [];
    public $recipeDetail = [];
    public $ingredients = [];

    public function incrementHighlight() {
        if ($this->selectedToHighlight === count($this->searchResult) - 1) {
            $this->selectedToHighlight = 0;
            return;
        }
        $this->selectedToHighlight++;
    }
    public function decrementHighlight() {
        if ($this->selectedToHighlight === 0) {
            $this->selectedToHighlight = count($this->searchResult) - 1;
            return;
        }
        $this->selectedToHighlight--;
    }

    public function resetState(){
        $this->searchQuery = "";
        $this->selectedToHighlight = "";
        $this->searchResult = [];
        $this->ingredients = [];
    }

    public function getRecipe($id){
        $recipe = Http::get("https://api.spoonacular.com/recipes/".$id."/information?apiKey=".env('SPOONACULAR_API'));
        $this->resetState();
        $this->recipeDetail = (array) new Recipe(
            $recipe['id'],
            $recipe['title'],
            $recipe['servings'],
            $recipe['image'],
            $recipe['readyInMinutes'],
            $recipe['sourceName'],
            $recipe['sourceUrl'],
            $recipe['healthScore'],
            $recipe['glutenFree'] == 1 ? "yes" : "no"
        );
    }

    public function getIngredients($id) {
        $this->ingredients = Http::get("https://api.spoonacular.com/recipes/".$id."/ingredientWidget.json?apiKey=".env('SPOONACULAR_API'))->json()['ingredients'];
    }

    public function render()
    {
        if (strlen($this->searchQuery) > 2) {
            $this->searchResult = Http::get("https://api.spoonacular.com/recipes/autocomplete?number=10&query=".$this->searchQuery."&apiKey=".env('SPOONACULAR_API'))
            ->json();
        }

        return view('livewire.auto-complete-handler', [
            'searchResult' => $this->searchResult,
            'recipeDetail' => $this->recipeDetail,
            'ingredients' => $this->ingredients
        ]);
    }
}
