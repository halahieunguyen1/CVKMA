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
        $string1 = "Xin Chào mọi người, tôi là Hiếu";
        $string2 = "Xin Chào Ho người, tôi Hiếu là";
        $array1 = ArrayChildIntersect::convertStringToArray($string1);
        $array2 = ArrayChildIntersect::convertStringToArray($string2);

        $intersect = ArrayChildIntersect::intersect($array1, $array2);
        $diffOne = ArrayChildIntersect::intersect1($array1, $intersect['value']);
        $diffTwo = ArrayChildIntersect::intersect1($array2, $intersect['value'], action: 'insert');
        dump($diffOne);
        dd($diffTwo);
    }
}
