<div class="w-4/6 m-auto autocomplete-container">

    <div class="search-form-control">
        <label for="search">Search</label>
        <input 
            wire:model.debounce.500ms="searchQuery" 
            type="text" 
            placeholder="pasta, chicken, egg, salad ..." 
            wire:keydown.arrow-up="decrementHighlight"   
            wire:keydown.arrow-down="incrementHighlight"   
            wire:keydown.escape="resetState"
        />
    </div>

    @if(strlen($searchQuery) > 2)
        <ul class="w-3/6 p-2 px-4 font-bold">
            @foreach($searchResult as $i => $item)
                <li 
                    wire:click="getRecipe({{ $item['id'] }})"
                    class="p-2 my-2 rounded-sm hover:bg-gray-200 {{ $selectedToHighlight === $i ? 'bg-gray-200' : '' }} "
                >{{ $item['title'] }}</li>
            @endforeach
        </ul>
    @endif

    @if($recipeDetail) 
        <div class="grid grid-cols-3 gap-5 mt-7 recipe">
            <img class="col-span-2 shadow-md" src="{{ $recipeDetail['image'] }}" alt="recipe">

            <div class="recipe-info">
                <p class="title">
                    {{ $recipeDetail['title'] }}
                </p>
                <p class="servings">Servings: {{ $recipeDetail['servings'] }}</p>
                <p class="readyIn">Ready in: {{ $recipeDetail['readyIn'] }} min</p>
                <p>Source:<a href="{{ $recipeDetail['sourceUrl'] }}" class="source">{{ $recipeDetail['sourceTitle'] }}</a></p>
                <p class="healthScore">Health score: {{ $recipeDetail['healthScore'] }}</p>
                <p class="glutenFree">Gluten free: {{ $recipeDetail['glutenFree'] }}</p>
                <button wire:click="getIngredients({{ $recipeDetail['id'] }})" class="rounded-md bg-gradient-to-br from-purple-900 to-indigo-500 get-ingredients" type="button">Get ingredients</button>
            </div>
        </div>
    @endif

    <div class="ingredients">
       @foreach($ingredients as $item)
        <p>~ {{ $item['name'] }} - {{ $item['amount']['metric']['value'] }}{{ $item['amount']['metric']['unit'] }}</p>
       @endforeach
    </div>

</div>
