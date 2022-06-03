@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Admin Guidelines</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="text-center">1. Importing Students</h3>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <ol>
                                            <li style="list-style-type: none; margin: 0; padding: 0;">
                                                <p>
                                                    <b>1.1</b>
                                                    <span>
                                                        You can import only microsoft excel files. i.e Files which have <b style="color: #DE1738;"> .xlsx </b> as the file extention.
                                                    </span>
                                                </p>
                                            </li>
                                            <li style="list-style-type: none; margin: 0; padding: 0;">
                                                <p>
                                                    <b>1.2</b>
                                                    <span>
                                                        Excel file <b>must</b> contain only <b style="color: #DE1738;"> one(1) </b> sheet.
                                                    </span>
                                                </p>
                                            </li>
                                            <li style="list-style-type: none; margin: 0; padding: 0;">
                                                <p>
                                                    <b>1.3</b>
                                                    <span>
                                                        First row of the file should be the heading row.Heading row contains column names.
                                                    </span>
                                                </p>
                                            </li>
                                            <li style="list-style-type: none; margin: 0; padding: 0;">
                                                <p>
                                                    <b>1.4</b>
                                                    <span>
                                                        The column names for <b style="color: #DE1738;">enrolment_no</b>, <b style="color: #DE1738;">full_name</b>, <b style="color: #DE1738;">email</b> & <b style="color: #DE1738;">nic</b> should be as exactly as shown here.
                                                        These columns <b>must</b> be present in the excel file. 
                                                    </span>
                                                </p>
                                            </li>
                                            <li style="list-style-type: none; margin: 0; padding: 0;">
                                                <p>
                                                    <b>1.5</b>
                                                    <span>
                                                        Columns for <b>address</b>, <b>telephone</b>, <b>city</b>, <b>province</b> are optional.
                                                        If these columns, present in the excel file, please select them when you are uploading excel file. they will be imported. Please note: column names are <b style="color: #DE1738;">case sensitive</b>. 
                                                    </span>
                                                </p>
                                            </li>
                                            <li style="list-style-type: none; margin: 0; padding: 0;">
                                                <p>
                                                    <b>1.6</b>
                                                    <span>
                                                        It is preferred that excel file <b>does not contain empty rows.</b> Empty rows are the rows which had data in the original file but deleted later.
                                                        You need to delete the row too. <br> Please follow this <a href="https://www.groovypost.com/howto/find-and-delete-blank-rows-in-microsoft-excel/">tutorial</a> if you do not know how to delete empty rows in a excel file.
                                                    </span>
                                                </p>
                                            </li>
                                        </ol>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <h5 class="text-center">Please contact ncsu if you found any difficulties importing students</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection