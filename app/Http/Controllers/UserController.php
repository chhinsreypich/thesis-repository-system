<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thesis;
use App\Models\Thesisfile;
use Illuminate\Support\Facades\Storage;
use Psy\Output\Theme;
use Illuminate\Support\Facades\URL;
use App\Models\Student;
use App\Models\Department;
use App\Models\Hod;
use App\Models\ThesisRequest;


class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $deptId = $user->student->dept_id;
        $deptTheses = Thesis::where('dept_id', $deptId)->count();
        $totalTheses = Thesis::count();

        $joinedYear = $user->student->start_year;

        $theses = Thesis::with(['user', 'department', 'hod'])
            ->where('dept_id', $deptId)
            ->latest('submission_date')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('theses', 'joinedYear', 'deptId', 'deptTheses', 'totalTheses'));
    }

    public function requestThesis()
    {
        $requests = ThesisRequest::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.requestThesis', compact('requests'));
    }
    public function createRequest()
    {
        return view('user.createRequest');
    }

    public function storeRequest(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'description' => 'required|string',
            'submission_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thesis_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('thesis_request_images', 'public') : null;
        $pdfPath = $request->file('thesis_file')->store('thesis_request_files', 'public');

        ThesisRequest::create([
            'user_id' => auth()->id(),
            'dept_id' => auth()->user()->student->dept_id,
            'title' => $data['title'],
            'abstract' => $data['abstract'],
            'description' => $data['description'],
            'submission_date' => $data['submission_date'],
            'image' => $imagePath,
            'pdf_file' => $pdfPath,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Thesis upload request sent to HOD.');
    }

    public function myOwnThesis()
    {
        $deptId = auth()->user()->student->dept_id;

        $theses = Thesis::where('dept_id', $deptId)
            ->with(['department', 'hod'])
            ->latest()
            ->get();

        return view('user.myOwnThesis', compact('theses'));
    }

    public function allThesis(Request $request)
    {
        $deptId = auth()->user()->student->dept_id;
        $query = Thesis::with(['user', 'department', 'hod']);

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abstract', 'like', "%{$search}%")
                    ->orWhere('submission_date', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('department', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $theses = $query->orderBy('submission_date', 'desc')->paginate(8);

        $theses->appends($request->all());
        return view('user.allThesis', compact('theses'));
    }


    // public function allThesis(Request $request)
    // {
    //     $query = Thesis::with(['user', 'department', 'hod']);

    //     if ($request->search) {
    //         $search = $request->search;

    //         $query->where(function ($q) use ($search) {
    //             $q->where('title', 'like', "%{$search}%")
    //                 ->orWhere('abstract', 'like', "%{$search}%")
    //                 ->orWhere('submission_date', 'like', "%{$search}%")
    //                 ->orWhereHas('user', function ($q2) use ($search) {
    //                     $q2->where('name', 'like', "%{$search}%");
    //                 })
    //                 ->orWhereHas('department', function ($q3) use ($search) {
    //                     $q3->where('name', 'like', "%{$search}%");
    //                 });
    //         });
    //     }

    //     $theses = $query->orderBy('submission_date', 'desc')->paginate(8);

    //     $theses->appends($request->all());

    //     return view('hod.allThesis', compact('theses'));
    // }


    public function thesisDetails(Thesis $thesis)
    {
        $thesis->load(['user', 'department', 'hod']);
        return view('user.thesisDetails', compact('thesis'));
    }

    public function viewPDF(Thesis $thesis)
    {
        if (!$thesis->file) {
            return redirect()->back()->with('error', 'PDF file not found.');
        }

        $filePath = storage_path('app/public/' . $thesis->file->file_path);

        //  open the pdf in the browser
        return response()->file($filePath);
    }

    public function downloadPDF(Thesis $thesis)
    {
        if (!$thesis->file) {
            return back()->with('error', 'PDF file not found.');
        }

        $filePath = storage_path('app/public/' . $thesis->file->file_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'PDF not found.');
        }

        return response()->download(
            $filePath,
            $thesis->file->file_name ?? 'thesis.pdf'
        );
    }
}
