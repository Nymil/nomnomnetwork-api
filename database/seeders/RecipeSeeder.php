<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        }
        fclose($file);
    }
}
