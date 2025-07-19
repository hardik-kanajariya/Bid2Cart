<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDemoData extends Command
{
    protected $signature = 'demo:backup {--tables=auction,product,users,bid_history}';
    protected $description = 'Backup demo data before restoration';

    public function handle()
    {
        $tables = explode(',', $this->option('tables'));
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $backupFile = "demo_backup_{$timestamp}.sql";
        
        $this->info("📦 Creating backup: {$backupFile}");
        
        $command = sprintf(
            'mysqldump -h %s -u %s -p%s %s %s > storage/backups/%s',
            config('database.connections.mysql.host'),
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            implode(' ', $tables),
            $backupFile
        );
        
        // Create backup directory if it doesn't exist
        if (!is_dir(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0755, true);
        }
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            $this->info("✅ Backup created successfully: {$backupFile}");
        } else {
            $this->error("❌ Backup failed");
        }
    }
}