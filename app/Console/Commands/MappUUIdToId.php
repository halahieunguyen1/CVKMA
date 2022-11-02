<?php

namespace App\Console\Commands;

use App\Jobs\CreateCvVersions;
use App\Models\DataCv;
use App\Models\User;
use App\Traits\SeederTrait;
use App\Models\Job\JobCvApply;
use Illuminate\Console\Command;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

class MappUUIdToId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:map-id';

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
        $file = fopen($filename, 'w');
        $cv = User::join('pii_users', function ($join) {
            $join->on('users.user_id', '=', 'pii_users.pii_user_id');
            })->get();
        foreach ($cv as $key => $c) {
            if ($c['email']) {

                fwrite($file, $c['user_id'].':'.( $c['unconfirm_email'] ?? $c['email'])."\n");
            }
        }
        fclose($file);
    }
}
