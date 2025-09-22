<?php

namespace App\Jobs;

use App\Http\Controllers\HelperController;
use App\Models\Organization;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchAssociatedOrg implements ShouldQueue
{
    use Queueable;
    public $timeout = 999999;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $uid, public array $org) {}


    /**
     * Execute the job.
     */
    public function handle()
    {
        $helper=new HelperController();
        $organizations=$this->org;
        foreach ($organizations as $org) {
            $helper->saveOrg($org,$this->uid);
        }
    }
}
