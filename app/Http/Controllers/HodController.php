<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thesis;
use App\Models\Student;
use App\Models\Thesisfile;
use App\Models\Department;
use App\Models\Hod;
use App\Models\ThesisRequest;
use Illuminate\Support\Facades\Storage;

class HodController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = auth()->user();
        $deptId = $user->hod->dept_id;

        $totalTheses = Thesis::where('dept_id', $deptId)->count();
        $pendingRequests = ThesisRequest::where('dept_id', $deptId)->where('status', 'pending')->count();
        $approvedRequests = ThesisRequest::where('dept_id', $deptId)->where('status', 'approved')->count();

        $theses = Thesis::with('department')
            ->where('dept_id', $deptId)
            ->latest('submission_date')
            ->take(6)
            ->get();

        $requests = ThesisRequest::with(['user', 'department'])
            ->latest('created_at')
            ->take(5)
            ->get();

        $joinedYears = $user->hod->year;

        return view('hod.dashboard', compact(
            'theses',
            'requests',
            'totalTheses',
            'pendingRequests',
            'approvedRequests',
            'joinedYears'
        ));
    } // 

    public function createThesis()
    {
        $departments = Department::all();
        return view('hod.createThesis', compact('departments'));
    }

    public function storeThesis(Request $request)
    {
        // validate input
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'description' => 'required|string',
            'submission_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thesis_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        // upload image if exists
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('thesis_images', 'public');
        }
        $deptId = auth()->user()->hod->dept_id;

        // note there are 2 tables: thesis and thesisfiles
        // thesis contains title, abstract, description, submission_date, image_path, poster_id, verify_by, dept_id
        // thesisfiles contains thesis_id and file_path (pdf file)
        // so we need to insert data into both tables

        // "thesis" table
        // create thesis record into "thesis" table except pdf file
        $thesis = Thesis::create([
            'title' => $data['title'],
            'dept_id' => $deptId,  // get dept_id from logged in HOD's record
            'abstract' => $data['abstract'],
            'description' => $data['description'],
            'posted_by' => auth()->id(),  // get current logged in user's id as poster_id
            'verify_by' => null,
            'submission_date' => $data['submission_date'],
            'image' => $imagePath ?? null,
        ]);

        // "thesisfiles" table        
        // upload thesis pdf into "thesisfiles" table
        $filePath = $request->file('thesis_file')->store('thesis_files', 'public');

        ThesisFile::create([
            'thesis_id' => $thesis->id, // get the id of the thesis record we just created
            'file_path' => $filePath
        ]);

        return redirect()->route('hod.dashboard')->with('success', 'Thesis uploaded successfully.');
    }

    public function myOwnThesis()
    {
        $user = auth()->user();
        $deptId = $user->hod->dept_id;

        $theses = Thesis::with('department')
            ->where('posted_by', auth()->id())
            ->orderBy('submission_date', 'desc')
            ->get();

        $departmentName = $user->hod->department->name;

        return view('hod.myOwnThesis', compact('theses', 'departmentName'));
    }


    public function allThesis(Request $request)
    {
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

        return view('hod.allThesis', compact('theses'));
    }


    public function editThesis($id)
    {
        $thesis = Thesis::findOrFail($id);

        if (auth()->user()->hod->dept_id !== $thesis->dept_id) {
            return redirect()->back()->with('error', 'This thesis is not in your department. You cannot edit it.');
        }

        $departments = Department::all();
        return view('hod.editThesis', compact('thesis', 'departments'));
    }

    public function updateThesis(Request $request, Thesis $thesis)
    {
        if (auth()->user()->hod->dept_id !== $thesis->dept_id) {
            return redirect()->route('hod.dashboard')
                ->with('error', 'This thesis is not in your department. You cannot edit it.');
        }

        // validate input
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'description' => 'required|string',
            'submission_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thesis_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // handle image upload
        if ($request->hasFile('image')) {
            $thesis->image = $request->file('image')->store('thesis_images', 'public');
        }

        // update other fields
        $thesis->title = $data['title'];
        $thesis->abstract = $data['abstract'];
        $thesis->description = $data['description'];
        $thesis->submission_date = $data['submission_date'];

        $thesis->save();

        // handle PDF file
        if ($request->hasFile('thesis_file')) {
            $filePath = $request->file('thesis_file')->store('thesis_files', 'public');

            $thesis->file()->updateOrCreate(
                ['thesis_id' => $thesis->id],
                ['file_path' => $filePath]
            );
        }

        return redirect()->route('hod.dashboard')->with('success', 'Thesis updated successfully.');
    }

    public function thesisDetails($id)
    {
        $thesis = Thesis::with(['user', 'department', 'hod'])->findOrFail($id);
        return view('hod.thesisDetails', compact('thesis'));
    }

    public function deleteThesis($id)
    {
        $thesis = Thesis::findOrFail($id);

        if (auth()->user()->hod->dept_id !== $thesis->dept_id) {
            return redirect()->back()->with('error', 'This thesis is not in your department. You cannot edit it.');
        }

        // delete pdf file
        if ($thesis->file && \Storage::disk('public')->exists($thesis->file->file_path)) {
            \Storage::disk('public')->delete($thesis->file->file_path);
        }

        // delete image
        if ($thesis->image && \Storage::disk('public')->exists($thesis->image)) {
            \Storage::disk('public')->delete($thesis->image);
        }

        // delete thesis record
        $thesis->delete();

        return redirect()->route('hod.dashboard')->with('success', 'Thesis deleted successfully.');
    }
    public function viewPDF(Thesis $thesis)
    {
        // check if pdf exists
        if (!$thesis->file) {
            return redirect()->back()->with('error', 'PDF file not found.');
        }

        $filePath = storage_path('app/public/' . $thesis->file->file_path);

        //  open the pdf in the browser
        return response()->file($filePath);
    }

    public function viewRequests()
    {
        $requests = ThesisRequest::with('user', 'department')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hod.viewRequests', compact('requests'));
    }

    public function viewRequestPDF($id)
    {
        $req = ThesisRequest::findOrFail($id);

        if (!$req->pdf_file || !Storage::disk('public')->exists($req->pdf_file)) {
            return redirect()->back()->with('error', 'PDF file not found.');
        }

        $filePath = storage_path('app/public/' . $req->pdf_file);

        return response()->file($filePath);
    }

    // approve a request
    public function approveRequest($id)
    {
        $req = ThesisRequest::findOrFail($id);
        // create the Thesis record
        $thesis = Thesis::create([
            'title' => $req->title,
            'dept_id' => $req->dept_id,
            'abstract' => $req->abstract,
            'description' => $req->description ?? '',
            'posted_by' => $req->user_id,
            'verify_by' => auth()->user()->hod->id,
            'submission_date' => $req->submission_date,
            'image' => $req->image ?? null,
        ]);

        ThesisFile::create([
            'thesis_id' => $thesis->id, // get the id of the thesis record we just created
            'file_path' => $req->pdf_file,  // get the file path 
        ]);

        $req->status = 'approved';
        $req->save();

        session()->flash('request_approved', "Your thesis request '{$req->title}' has been approved!");

        return redirect()->route('hod.dashboard')->with('success', 'Request approved and thesis created.');
    }

    // reject a request
    public function rejectRequest($id)
    {
        $req = ThesisRequest::findOrFail($id);
        $req->status = 'rejected';
        $req->save();

        return redirect()->route('hod.dashboard')->with('error', 'Request rejected.');
    }
}
