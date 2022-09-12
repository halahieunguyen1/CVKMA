<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class MoveDbCv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:data-cv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = DB::connection('mysql_cvo')->table('users')->get();
        foreach ($users as $user) {
            $data = [];
            foreach ($user as $key => $attr) {
                if ($attr = '0000-00-00 00:00:00') continue;
                $data[$key] = $attr;
            }
            $newUser = User::create($data);
        }
    }
}
