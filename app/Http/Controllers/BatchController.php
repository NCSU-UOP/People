<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Faculty;
use LdapRecord\Models\ActiveDirectory\OrganizationalUnit;

class BatchController extends Controller
{
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'same' => 'The :attribute and :other must match.',
        'size' => 'The :attribute must be exactly :size.',
        'min' => 'The :attribute must be greater than :min characters.',
        'max' => 'The :attribute must be less than :max characters.',
        'between' => 'The :attribute value :input is not between :min - :max.',
        'in' => 'The :attribute must be one of the following types: :values',
        'unique' => 'The :attribute is already in use.',
        'exists' => 'The :attribute is invalid.',
        'regex' => 'The :attribute format is invalid.',
        'email' => 'Invalid email.',
        'string' => 'The :attribute must be a string.',
        'date' => "The :attribute must be a date",
        'after_or_equal' => 'The :attribute is invalid.'
    ];

    // (super admin) create batch page
    public function createBatch()
    {
        $expireDate = now()->addYear(env('EXPIRED_IN', 4))->format('Y-m-d');
        $minDate = now()->format('Y-m-d');
        return view('batch.createBatch', compact('expireDate', 'minDate'));
    }

    // Add a batch to the system POST method
    public function addBatch()
    {
        $minDate = now()->format('Y-m-d');

        $batchData = request()->validate([
            'id' => ['required','int', 'unique:batches'],
            'expire_date' => ['required', 'date', 'after_or_equal:'.$minDate]
        ], $this->messages);

        // dd($batchData);
        try {
            // Create Organizational unit for the new batch
            $this->createBatchOU($batchData['id']);

            // If AD OU creates successfully, then the batch data will be added to the local database
            Batch::create($batchData);

        } catch (\Throwable $th) {
            abort(500, 'Error{$th}');
        }

        return redirect('/dashboard/add/batch')->with('message', 'Batch has been created Succesfully 👍');
    }

    /**
     * Create new organization unit for a batch
     */
    private function createBatchOU($batchId)
    {
        $faculties = Faculty::select('name')->get()->toArray();

        // Create batch organization unit for each faculty
        foreach ($faculties as $key => $faculty) {
            $DN_Level = "OU=".$batchId.", OU=Undergraduate, OU=Students, OU=".$faculty['name'].", ".env('LDAP_BASE_DN');            
            if(!OrganizationalUnit::find($DN_Level)) {
                $ou = new OrganizationalUnit();
                $ou->setDn($DN_Level);
                $ou->save();
            }
        }
    }
}
