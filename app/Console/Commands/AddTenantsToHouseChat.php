<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\House;
use App\Conversation;

class AddTenantsToHouseChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:house';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command per inserire inquilini nella chat della casa';

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
        $conversations = Conversation::isHouse()->get();
        foreach($conversations as $conversation){
            if($house = House::find($conversation->house_id)){
                $conversation->users()->sync($house->relatedUsers());
            }
        }
    }
}
