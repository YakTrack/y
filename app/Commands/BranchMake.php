<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BranchMake extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'branch:make {name?} {prefix?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Make a new branch';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $taskName = $this->argument('name') ?? $this->ask('Enter task name');
        $taskPrefix = $this->argument('name') ?? $this->ask('Enter task prefix');

        $this->info('Creating new branch named '.$branchName = ($taskPrefix ? $taskPrefix.'-' : '').ucfirst(str_slug($taskName)));

        $process = new Process(['git', 'checkout', '-b', $branchName]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
