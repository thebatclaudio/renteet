<?php

use Illuminate\Database\Seeder;
use App\Review;
use App\User;

class CreateFakeReview extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $review = new Review;
        $review->title = "Ottimo davvero";
        $review->text = "esperienza ottima";
        $review->rate = 5;
        $review->from_user_id = User::first()->id;
        $review->to_user_id = User::first()->id+1;
        $review->lessor = true;
        $review->save();
    }
}
