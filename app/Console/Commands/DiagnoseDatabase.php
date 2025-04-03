<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DiagnoseDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:database {tables?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose database issues by showing table structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = $this->argument('tables');

        if (empty($tables)) {
            // Get all tables from the database
            $tables = collect(DB::select('SHOW TABLES'))->map(function ($val) {
                $table = get_object_vars($val);
                return reset($table);
            })->toArray();
        }

        $this->info('Examining database tables structure...');
        $this->newLine();

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                $this->error("Table '$table' does not exist!");
                continue;
            }

            $columns = Schema::getColumnListing($table);

            $this->info("Table: {$table}");
            $this->line("Columns: " . implode(', ', $columns));

            $this->table(
                ['Column', 'Type', 'Nullable', 'Default'],
                collect($columns)->map(function ($column) use ($table) {
                    $type = DB::connection()->getDoctrineColumn($table, $column)->getType()->getName();
                    $nullable = !DB::connection()->getDoctrineColumn($table, $column)->getNotnull() ? 'YES' : 'NO';
                    $default = DB::connection()->getDoctrineColumn($table, $column)->getDefault();
                    $default = $default === null ? 'NULL' : $default;

                    return [$column, $type, $nullable, $default];
                })->toArray()
            );

            // Print a few sample rows
            $rows = DB::table($table)->take(5)->get();
            if (count($rows) > 0) {
                $this->info("Sample data (up to 5 rows):");
                $headers = array_keys(get_object_vars($rows[0]));
                $this->table(
                    $headers,
                    $rows->map(function ($row) {
                        return array_map(function ($value) {
                            return is_array($value) || is_object($value)
                                ? json_encode($value)
                                : (is_null($value) ? 'NULL' : (string) $value);
                        }, get_object_vars($row));
                    })->toArray()
                );
            } else {
                $this->line("No data in this table.");
            }

            $this->newLine();
        }

        return 0;
    }
}
