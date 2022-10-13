<?php

namespace App\Console\Commands;

use App\Jobs\CreateCvVersions;
use App\Models\DataCv;
use App\Models\User;
use App\Traits\SeederTrait;
use App\Models\JobCvApply;
use Illuminate\Console\Command;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

class MappUUIdToId2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:map-id-2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill data cv into cv_versions and data_cv_versions table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = 'id.txt';
        $newfilename = 'uuid.txt';
        $file = fopen($filename, 'r');
        $newfile = fopen($newfilename, 'w');
        while(!feof($file)) {
            $line = fgets($file);
            $email = trim(explode(':',$line)[1]."\n");
            $user = User::where('email',$email)->first();
            fwrite($newfile, trim(explode(':',$line)[0]."\n") .':'.$user['uuid']."\n");
        }
        fclose($newfile);
        fclose($file);
    }
}
