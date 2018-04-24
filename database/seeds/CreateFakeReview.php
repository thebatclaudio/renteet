<?php

use Illuminate\Database\Seeder;
use App\Review;

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
        $review->from_user_id = 6;
        $review->to_user_id = 5;
        $review->lessor = true;
        $review->save();
    }
}
