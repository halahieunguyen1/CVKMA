<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Login extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:check-ping';

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
        $text = "<span>S<span>S";
        $patterns = '/(<span>(S))/';
        $replacements = '<s${2}<S';
        $new_text = preg_replace($patterns, $replacements, $text);
        dd($new_text);
        $patterns = ['/(([A-Z][a-z]+, )+[A-Z][a-z]+)/', '/\d{10}/'];
$replacements = ['${1}, Amanda, Ashley, Susan', 'contact@test.com'];
 
$text = 'Adam, Andrew, Shaun or Monty will answer all your questions if you contact us at 1234567890 on weekdays between 9:00AM to 5:00PM.';
 
$new_text = preg_replace($patterns, $replacements, $text);
 
var_dump($new_text);
        // $start_time = microtime(true);
        // exec("ping  -n 1 172.67.12.198", $output, $rus);
        // $end = microtime(true);
        // echo $rus;
        // echo $end - $start_time;
        // echo "\n";
        // $client = new \GuzzleHttp\Client();
        // $start_time = microtime(true);
        // $res = $client->request('GET', 'https://www.topcv.vn/viec-lam', [
        //     'headers' => [
        //         'Content-Type' => 'application/json',
        //     ],
        // ]);
        // $end = microtime(true);
        // echo $end - $start_time;
        // $body = json_decode((string)$res->getBody(), true);

        // dd($body);
        return 0;
    }
}
