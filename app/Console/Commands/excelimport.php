<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\UsersImport;

class excelimport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Excel importer';

    /**
     * Execute the console command.
     *
     * 
     */
    public function handle()
    {
        $this->output->title('Starting import');
        (new UsersImport)->withOutput($this->output)->import(public_path('/uploads/excelfiles/efac.xlsx'));
        $this->output->success('Import successful');
    }
}
