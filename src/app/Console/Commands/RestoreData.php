<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RestoreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:restore-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the database and clear uploads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->restoreDatabase();
        $this->clearUploads();
    }

    private function restoreDatabase(): void
    {
        if (Storage::disk('database')->exists('database.sqlite.example')) {
            // Copy and override the database.sqlite.example file to database.sqlite
            Storage::disk('database')->copy('database.sqlite.example', 'database.sqlite');
        }
    }

    private function clearUploads(): void
    {
        $driver = Storage::getDefaultDriver();
        // Clear all files in the storage/app/public directory
        if ($driver == 'public') {

            Storage::disk($driver)->deleteDirectory('');
        }
    }
}
