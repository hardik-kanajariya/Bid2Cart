<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('userid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('canada');
            $table->string('zip');
            $table->string('phone');
            $table->string('ads')->default("");
            $table->string('username')->unique();
            $table->boolean('news_latter')->default(0);
            $table->string('status')->default('pending');
            $table->string('email')->unique();
            $table->string('mail_hash')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable(); // Added
            $table->string('avatar')->nullable(); // Added
            $table->rememberToken();
            $table->timestamps();
        });

        $username = [
            0 => 'MoonBabe',
            1 => 'WhiteGhost',
            2 => 'Smoke&Fire',
            3 => 'BlueberryBelle',
            4 => 'CottonCandyQueen',
            5 => 'TropicalParadise',
            6 => 'VanillaSky',
            7 => 'SweetMelody',
            8 => 'CherryPoppins',
            9 => 'DreamCatcher',
            10 => 'StarsAndStripes',
            11 => 'CottonTails',
            12 => 'BabyDolly',
            13 => 'PeachyCream',
            14 => 'PrettyInPink',
            15 => 'SugaryDreams',
            16 => 'UnkissedBabe',
            17 => 'PrincessPeach',
            18 => 'DiamondsAreForever',
            19 => 'WatercolorWanderlust',
            20 => 'Sunshine',
            21 => 'Moonlight',
            22 => 'Dreamlike',
            23 => 'SparkleQueen',
            24 => 'ButterflyHeart',
            25 => 'StarDust',
            26 => 'SunshineFlower',
            27 => 'RainbowGlow',
            28 => 'UnicornLove',
            29 => 'SkylineBabe',
            30 => 'Aquamarine',
            31 => 'CherryBlossom',
            32 => 'Dragonroot',
            33 => 'SmoothOperator',
            34 => 'RockingIt',
            35 => 'AboveHeights',
            36 => 'DoNotDisturb',
            37 => 'HotAndSpicy',
            38 => 'WannaBeMe',
            39 => 'OneInAMillion',
            40 => 'TheRealDeal',
            41 => 'AllAboutThatBase',
            42 => 'SimplyTheBest',
            43 => 'InItToWinIt',
            44 => 'NoOneCanBeatMe',
            45 => 'SuperDuperCool',
            46 => 'GiveMeAHighFive',
            47 => 'RockerGirl',
            48 => 'BadAssBiker',
            49 => 'CrazyCoolKid',
        ];

        foreach ($username as $key ) {
            $new = new User();
            $new->first_name = $username[rand(0, 25)];
            $new->last_name = $username[rand(25, 49)];
            $new->address = '';
            $new->city = '1';
            $new->state = '1';
            $new->zip = rand(111111,999999);
            $new->status = 'active';
            $new->phone = rand(1111111111, 9999999999);
            $new->username = $key;
            $new->email = $key . '@mail.com';
            $new->mail_hash = md5($key . '@mail.com');
            $new->email_verified_at = Carbon::now()->toDateTimeString();
            $new->username = $key;
            $new->password = bcrypt('123@bot');
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
        Schema::dropIfExists('users');
    }
}
