<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:reminders {--f|filter=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run reminder checking command in group';

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
        $commands = config('remindercommands');

        if($this->option('filter')){
            if(array_key_exists($this->option('filter'), $commands)){
                $this->info("Checking remaining jobs for ". $this->option('filter') ."...");
                foreach($commands[$this->option('filter')] as $command){
                    $this->call($command);
                }
                $this->info("Done!");
            }
            else{
                $this->error('Wrong filter option! Filter option must be one of them or none :');
                $this->info(implode(', ', array_keys($commands)));
            }
        }
        else{
            $name = $this->choice('Sure to check all reminders?', ['No', 'Yes']);
            if($name == "Yes"){
                $this->info("Checking all remaining jobs! Wait for a minute ...");

                foreach($commands as $key => $command){
                    $this->info("Checking remaining jobs for ".$key."...");
                    foreach($command as $commandName){
                        $this->call($commandName);
                    }
                    $this->info("Done!");
                }
                $this->info("Checking finished!");
            }
            else{
                $this->line("Cancel!");
            }
        }
    }
}
