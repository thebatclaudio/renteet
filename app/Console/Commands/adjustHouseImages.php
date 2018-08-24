<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class adjustHouseImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adjust:houseImages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(\App\House::all() as $house) {
            if($house->id > 9)
            foreach($house->photos as $photo) {
                $imageName = \Carbon\Carbon::now()->timestamp.rand(0,99999);

                \Image::make(public_path('images/houses/'.$house->id). "/".$photo->file_name)->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $imageName."-1920.jpg");

                \Image::make(public_path('images/houses/'.$house->id). "/".$photo->file_name)->resize(320, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $imageName."-320.jpg");

                \Image::make(public_path('images/houses/'.$house->id). "/".$photo->file_name)->resize(670, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $imageName."-670.jpg");

                \Image::make(public_path('images/houses/'.$house->id). "/".$photo->file_name)->resize(220, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $imageName."-220.jpg");

                \Image::make(public_path('images/houses/'.$house->id). "/".$photo->file_name)->resize(490, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/houses/'.$house->id). "/". $imageName."-490.jpg");

                $photo->file_name = $imageName;
                $photo->save();
            }
        }
    }
}
