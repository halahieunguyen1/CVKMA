<?php

namespace App\Console\Commands;

use App\Jobs\CreateCvVersions;
use App\Models\DataCv;
use Illuminate\Console\Command;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

class FillDataCVersions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cv-version:fill-data';

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
        /**
         * Các bước thực hiện
         * B1: Duyệt các bảng cần đánh version, ví dụ cvo.data_cvs
         * B3: Tại mỗi record cv tương ứng, tạo 1 record ở bảng cvo.cv_versions
         * B4: Tương ứng với mỗi bảng ghi cv_versions thì tạo 1 bản ghi ở bảng data_cv_version
         *      - Nếu data đã có thì lấy data_cv_version_id ở bản ghi đã có
         *      - Nếu chưa tồn tại bảng ghi có data tương ứng thì tạo mới rồi lấy data_cv_version_id mới tạo cập nhật lại bảng đang migrate (ở đây là cvo.data_cvs)
         */
        $size = 2000;
        $jobs = [];

        // cvo.data_cvs
        $maxDataCvId = DataCv::query()->orderByDesc('data_cv_id')->first()->data_cv_id ?? 0;
        for ($i = 0; $i < ceil($maxDataCvId / $size); $i++) {
            $from = $size * $i + 1;
            $to = $from + $size - 1;
            $jobs[] = new CreateCvVersions($from, $to, DataCV::class, 'data_cv_id');
        }

        $batch = Bus::batch($jobs)->then(function (Batch $batch) {
            // All jobs completed successfully...
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
        })->allowFailures(true)
            ->dispatch();

        return $batch->id;
    }
}
