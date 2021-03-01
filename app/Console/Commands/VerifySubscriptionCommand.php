<?php

namespace App\Console\Commands;

use App\Jobs\VerifySubscriptionJob;
use App\Services\SubscriptionService;
use App\Services\Thirdparties\GoogleVerifySubscription;
use Illuminate\Console\Command;

class VerifySubscriptionCommand extends Command
{
    public $subscriptionService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start of subscriptions processing command');

        $res = $this->subscriptionService->expiredSubscriptions();
        $count = $res->count();
        $this->info("{$count} jobs to process");

        $res->each(function($sub){
            VerifySubscriptionJob::dispatch($sub)->onQueue('api');;
        });

        $this->info("Queued {$count} jobs");

    }
}
