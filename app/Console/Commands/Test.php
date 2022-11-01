<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libs\ArrayChildIntersect;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $intersect = ArrayChildIntersect::intersect([1, 2, 3, 5, 7, 8, 9, 1, 4], [4, 2, 3, 5, 8, 7, 8, 9, 1]);    
        $diffOne = ArrayChildIntersect::intersect1([1, 2, 3, 5, 7, 8, 9, 1, 4], $intersect['value']);
    }
}
