<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Notifications\ReportVerified;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $reports = Report::leftJoin('users as employers', 'employers.id', '=', 'reports.employer_id')
            ->leftJoin('users as employees', 'employees.id', '=', 'reports.employee_id')
            ->select('reports.*', 'employers.name as employer_name', 'employees.name as employee_name')
            ->paginate(5);
        // ->get(); 



        // $reports = Report::join('users', 'users.id', '=','reports.employer_id')->get(['reports.*', 'users.name']);
        // dd($reports);
        $pendingFiles =  Report::leftJoin('users as employers', 'employers.id', '=', 'reports.employer_id')
            ->leftJoin('users as employees', 'employees.id', '=', 'reports.employee_id')
            ->select('reports.*', 'employers.name as employer_name', 'employees.name as employee_name')
            ->whereIn('status', ['pending', ''])->get();

        $verifiedFiles =   Report::leftJoin('users as employers', 'employers.id', '=', 'reports.employer_id')
            ->leftJoin('users as employees', 'employees.id', '=', 'reports.employee_id')
            ->select('reports.*', 'employers.name as employer_name', 'employees.name as employee_name')
            ->whereIn('status', ['accepted', 'rejected'])->get();
        // $report = Report::with(['users'])->get();
        // dd($verifiedFiles);
        return Inertia::render('Report/Index', [
            'reports' => $reports,
            'pendingFiles' => $pendingFiles,
            'verifiedFiles' => $verifiedFiles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'filename' => 'required|string',
        ]);
        $file = $request->file('file');
        $filepath = $file->store('public/reports');

        $fileRecord = new Report([
            'employee_id' => auth()->user()->id,
            'file_path' => $filepath,
            'name' => $request->filename,
            'status' => 'pending'
        ]);

        $employers  = User::role('employer')->get();
        // dd($employer);
        // $employer->notify(
        //     new ReportVerified($fileRecord)
        // );
        // Notify each employer individually
        foreach ($employers as $employer) {
            $employer->notify(new ReportVerified($fileRecord));
        } 
        $fileRecord->save();
        return redirect()->route('report.index')->with('message', 'Report Submitted Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $filepath = $report->file_path;
        $fileExtension = pathinfo($filepath, PATHINFO_EXTENSION);
        if (in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
            // View the file
            return response()->file(storage_path('app/' . $filepath));
        } else {
            // Download the file with the extension name
            return Storage::download($filepath, $report->name . '.' . $fileExtension);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required',
        ]);
        // dd($report->employee);
        $report->employer_id = auth()->user()->id;
        $report->status = $request->status;
        $report->feedback = $request->feedback;


        $user = $report->employee;
        $user->notify(
            new ReportVerified($report)
        );

        $report->save();
        return redirect()->route('report.index')->with('message', 'Report Verified');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('report.index')->with('message', 'Report Deleted');
    }
}
