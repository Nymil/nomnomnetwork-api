<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('recipes.csv');

        $file = fopen($path, 'r');

        // skip the first line
        fgetcsv($file);

        // to keep the same timestamps for the seeder
        $startTime = 1720467154;
        while (($line = fgetcsv($file, 0, ',')) !== FALSE) {
            $creatorId = DB::table('users')->inRandomOrder()->value('id');

            $recipe = new Recipe();
            $recipe->name = $line[0];
            $recipe->creator_id = $creatorId;
            $recipe->image_url = "not implemented yet";
            $recipe->category = $line[1];
            $recipe->calories = $line[2];
            $recipe->ingredients = explode(',', $line[3]);
            $recipe->instructions = $line[4];

            $recipe->save();

            $baseImageName = basename($recipe->name, "jpg");
            $imageName = Str::slug($baseImageName) . "-" . $startTime . ".jpg";

            $recipe->image_url = "/api/images/" . $imageName;
            $recipe->save();
            $startTime++;
        }
        fclose($file);

        $like = new Like();
        $like->user_id = 2;
        $like->recipe_id = 1;
        $like->save();
    }
}
