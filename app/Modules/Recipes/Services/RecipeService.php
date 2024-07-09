<?php

namespace App\Modules\Recipes\Services;

use App\Models\Recipe;
use App\Modules\Core\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeService extends Service {

    protected $rules = [
        'add' => [
            'name' => 'required|string',
            'creator_id' => 'required|integer|exists:users,id|min:1',
            'category' => 'required|string|in:appetizers,starters,maindishes,"desserts"',
            'calories' => 'required|integer|min:3',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'string', // Each ingredient must be a string
            'instructions' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]
    ];

    public function __construct(Recipe $model)
    {
        parent::__construct($model);
    }

    private function addCreatorToRecipe($recipe) {
        $recipe->creator = DB::table('users')->where('id', $recipe->creator_id)->value('name');
        return $recipe;
    }

    private function transformToSimple($recipe) {
        return [
            'id' => $recipe->id,
            'name' => $recipe->name,
            'creator' => $recipe->creator,
            'image_url' => $recipe->image_url
        ];
    }

    public function addLikesToRecipe($recipe) {
        if ($recipe->likes === null) {
            $recipe->likes = [];
            return $recipe;
        }

        $recipe->liked_by = $recipe->likes->map(function ($like) {
            return $like->user->name;
        });

        return $recipe;
    }

    public function getRecipe($id) {
        $recipe = $this->model->find($id);

        if (!$recipe) {
            return null;
        }

        $recipeWithCreator = $this->addCreatorToRecipe($recipe);

        return $this->addLikesToRecipe($recipeWithCreator);
    }

    public function allRecipes($search, $category) {
        $query = $this->model->query();

        $query->where('name', 'like', "%$search%");
        
        $possibleCategories = ['appetizers', 'starters', 'maindishes', 'desserts'];
        if (in_array($category, $possibleCategories)) {
            $query->where('category', $category);
        }

        $returnData = $query->get();
        
        // we only need the creator name, the name of the recipe and the image url
        return $returnData->map(function ($recipe) {
            $recipe = $this->addCreatorToRecipe($recipe);
            return $this->transformToSimple($recipe);
        });
    }

    public function addRecipe($data, String $ruleKey = "add") {
        if (!$this->validate($data, $ruleKey)) {
            return;
        }

        $recipe = new Recipe();
        $recipe->name = $data['name'];
        $recipe->creator_id = $data['creator_id'];
        $recipe->image_url = "not implemented yet";
        $recipe->category = $data['category'];
        $recipe->calories = $data['calories'];
        $recipe->ingredients = $data['ingredients'];
        $recipe->instructions = $data['instructions'];
        $recipe->save();

        // Handle image upload
        if (isset($data['image'])) {
            $image = $data['image'];
            $baseImageName = basename($recipe->name, $image->extension());
            $imageName = Str::slug($baseImageName) . "-" . time() . "." . $image->extension();
            $image->move(storage_path('app/images'), $imageName);
            $recipe->image_url = "/images/" . $imageName;
            $recipe->save();
        }

        return $this->getRecipe($recipe->id);
    }

    public function deleteRecipe($id) {
        $recipe = $this->model->find($id);

        if (!$recipe) {
            return null;
        }

        $recipe->delete();
        return $recipe;
    }
}