<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id("cat_id");
            $table->string("category_name");
            $table->string('category_thumbnail');
            $table->timestamps();
        });

        
        // Inserting some Categories

        $list = ['AUTO', 'BABIES', 'BEAUTY', 'BOOKS', 'COLLECTIBLE', 'ELECTRONICS', 'FOOD & BEVERAGES', 'FOOTWEAR', 'FURNITURE', 'GAMES', 'HEALTH', 'HOBBIES', 'JEWELRY', 'KIDS', 'MENS', 'HOME & UPGRADES', 'HOME & GARDEN', 'MUSIC', 'OUTDOORS', 'PETS', 'SPORT', 'SUPPLIES', 'TOOLS', 'TOYS', 'WOMANS'];

        $images = [
            'category_thumbnail_1665896001.png',
            'category_thumbnail_1665896002.png',
            'category_thumbnail_1665896003.png',
            'category_thumbnail_1665896004.png',
            'category_thumbnail_1665896005.png',
            'category_thumbnail_1665896006.png',
            'category_thumbnail_1665896007.png',
            'category_thumbnail_1665896008.png',
            'category_thumbnail_1665896009.png',
            'category_thumbnail_1665896010.png',
            'category_thumbnail_1665896011.png',
            'category_thumbnail_1665896012.png',
            'category_thumbnail_1665896013.png',
            'category_thumbnail_1665896014.png',
            'category_thumbnail_1665896015.png',
            'category_thumbnail_1665896016.png',
            'category_thumbnail_1665896017.png',
            'category_thumbnail_1665896018.png',
            'category_thumbnail_1665896019.png',
            'category_thumbnail_1665896020.png',
            'category_thumbnail_1665896021.png',
            'category_thumbnail_1665896022.png',
            'category_thumbnail_1665896023.png',
            'category_thumbnail_1665896024.png',
            'category_thumbnail_1665896025.png'
        ];

        for($i = 0; $i < count($list); $i++){
            $new = new Category();
            $new->category_name = $list[$i];
            $new->category_thumbnail = $images[$i];
            $new->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
