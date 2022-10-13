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

class FillUUId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:fill-uuid';

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
        $filename = 'uuid.txt';
        $file = fopen($filename, 'r');
        $x=0;
        while(!feof($file)) {
            $x++;
            dump($x);
            $line = fgets($file);
            [$id, $uuid] = explode(':',trim($line, "\n"));
            DataCv::where('user_id', $id)
            ->update(['user_uuid' => $uuid]);
            JobCvApply::where('user_id', $id)
            ->update(['user_uuid' => $uuid]);
        }
        fclose($file);
    }
}
