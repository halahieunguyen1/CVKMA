<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class IndexJson extends Command
{
    /**
     * 
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:index-json';

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
        $dbh = new PDO('mysql:dbname=CVKMA;host=127.0.0.1;port=3306', 'root', '');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "ALTER TABLE `data_cv_version` ADD COLUMN `email_virtual` INT GENERATED ALWAYS AS (`data` ->> '$.profile.email') NOT NULL AFTER `data`; ";
        $stmt = $dbh->execute($sql);
        $sql = "CREATE INDEX `data_cv_version_email_idx` ON `data_cv_version`(`email_virtual`);";
        $stmt = $dbh->execute($sql);
        // ALTER TABLE `players` ADD COLUMN `times_virtual` INT GENERATED ALWAYS AS (`player_and_games` ->> '$.games_played.Puzzler.time') NOT NULL AFTER `tennis_lost_virtual`; 
        return 0;
    }
}
