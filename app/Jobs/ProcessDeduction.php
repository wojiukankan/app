<?php

namespace App\Jobs;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessDeduction implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * @var User
     */
    private $user;
    private $data;

    /**
     * Create a new job instance.
     * @param User $user
     * @param $data
     */
    public function __construct(User $user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }


    /**
     * @var int
     */
    public $uniqueFor = 30;

    public function uniqueId()
    {
        return $this->user->id;
    }


    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            if(!$this->user->updateOrFail($this->data)){
                throw new Exception("db更新失败");
            }
        } catch (\Throwable $e) {
            $this->fail($e);
            throw $e;
        }
    }

    /**
     * 处理失败作业
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("更新失败" . $exception->getMessage(), $this->data);
    }

}
