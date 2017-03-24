<?php

namespace App\Console\Commands\Importers;

use Illuminate\Console\Command;
use App\Jobs\Importers\MigrateUsers;

class UserImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates Users from the old phpmap.co';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Importing users..');

        try {
            $url = 'https://phpmap.co/public/users';
            $users = json_decode(file_get_contents($url));

            dispatch(new MigrateUsers($users));

            $this->info('Users successfully imported!');
        } catch (\Exception $e) {
            $this->error('Can´t migrate users: '.$e->getMessage());
        }
    }
}
