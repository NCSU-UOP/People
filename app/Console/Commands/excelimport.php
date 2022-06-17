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
        try {
            $arr = [1=>'faculty_id',2=>'batch_id',3=>'usertype',4=>'address',5=>'initial', 6=>'fullname'];
            $import = new UsersImport(4,20,1,$arr,1);
            ($import)->withOutput($this->output)->import(public_path('/uploads/excelfiles/efac_20.xlsx'));
            $this->output->success('Import successful');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            foreach ($failures as $failure) {
                // dd($failure->row()); // row that went wrong
                // dd($failure->attribute()); // either heading key (if using heading row concern) or column index
                // dd($failure->errors()); // Actual error messages from Laravel validator
                // dd($failure->values()); // The values of the row that has failed.
            }
            // dd($failures);
        }
    }
}