<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AuthService;

class InitAuthTokenData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-auth-token-data {--grantToken=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $grantToken = $this->option('grantToken');

        if (!$grantToken) {
            $this->error('You can\'t use this option without grantToken option');

            return;
        }

        try {
            (new AuthService())->getAuthToken($grantToken);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
