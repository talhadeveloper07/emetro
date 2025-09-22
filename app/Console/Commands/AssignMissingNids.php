<?php

namespace App\Console\Commands;

use App\Models\Organization;
use Illuminate\Console\Command;

class AssignMissingNids extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'organizations:assign-nids';

    /**
     * The console command description.
     */
    protected $description = 'Assign NID values to organizations that don\'t have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting NID assignment...');

        $updatedCount = Organization::assignMissingNids();

        if ($updatedCount > 0) {
            $this->info("Successfully assigned NIDs to {$updatedCount} organizations.");
        } else {
            $this->info('No organizations found without NIDs.');
        }

        return Command::SUCCESS;
    }
}
