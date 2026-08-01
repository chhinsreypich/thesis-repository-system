<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Thesis;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        $totalHod = Hod::count(); // total Hod
        $activeHod = Hod::whereHas('user', function ($q) {
            $q->where('status', 'active');
        })->count();  // count active Hod

        $totalThesis = Thesis::count(); // total theses
        $theses = Thesis::with(['user', 'department', 'hod'])
            ->latest('submission_date')
            ->take(8)
            ->get();

        $hods = Hod::with(['user', 'department'])
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalHod',
            'activeHod',
            'totalThesis',
            'theses',
            'hods'
        ));
    }

    public function createHod()
    {
        $departments = Department::all();
        return view('admin.createHod', compact('departments'));
    }

    public function storeHod(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:hods,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'dept_id' => 'required|exists:departments,id',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'status' => 'required|string|in:active,inactive',
        ]);

        DB::transaction(function () use ($request) { // DB:transaction: makee sure both user and Hod are created together 
            // create user record in Users table
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'hod',
                'password' => Hash::make($request->password),
            ]);

            /// note: Hod and User table are different, and we need to create both records.
            /// because in user table, there is no dept_id, year, status attr to insert Hod's data. 
            /// that's why i create hod table to store these info

            /// create Hod record in Hod table 
            Hod::create([
                'user_id' => $user->id,
                'dept_id' => $request->dept_id,
                'username' => $request->username,
                'year' => $request->year,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('admin.dashboard')->with('success', 'HoD account created successfully.');
    }

    public function editPage(Request $request)
    {
        $hods = Hod::with(['department', 'user'])->get();
        $query =  Thesis::with(['user', 'department', 'hod']);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('abstract', 'like', '%' . $request->search . '%')
                ->orWhere('submission_date', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('department', function ($q3) use ($request) {
                    $q3->where('name', 'like', '%' . $request->search . '%');
                });;
        }

        $theses = $query->orderBy('submission_date', 'desc')->paginate(8); // cuz i display 4 columns each row

        // keep search query in pagination links
        $theses->appends($request->all());
        return view('admin.dashboard', compact('hods', 'theses'));
    }

    public function editHod($id)
    {
        $hod = Hod::findOrFail($id);
        $departments = Department::all();
        return view('admin.editHod', compact('hod', 'departments'));
    }

    public function hodList(Request $request)
    {
        $query = Hod::with(['department', 'user']);

        if ($request->search) {
            $search = $request->search;

            $query->where('username', 'like', '%' . $search . '%')
                ->orWhere('year', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('department', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        $hods = $query->latest()->paginate(8);

        $hods->appends($request->all());

        return view('admin.hodList', compact('hods'));
    }

    public function thesisList(Request $request)
    {
        $hods = Hod::with(['department', 'user'])->get();
        $query =  Thesis::with(['user', 'department', 'hod']);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('abstract', 'like', '%' . $request->search . '%')
                ->orWhere('submission_date', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('department', function ($q3) use ($request) {
                    $q3->where('name', 'like', "%{$request->search}%");
                });;
        }

        $theses = $query->orderBy('submission_date', 'desc')->paginate(8);

        // keep search query in pagination links
        $theses->appends($request->all());
        return view('admin.thesisList', compact('hods', 'theses'));
    }

    public function updateHod(Request $request, $id)
    {
        $hod = Hod::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:hods,username,' . $hod->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $hod->user_id,
            'password' => 'nullable|string|min:6|confirmed',
            'dept_id' => 'required|exists:departments,id',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'status' => 'required|string|in:active,inactive',
        ]);

        DB::transaction(function () use ($request, $hod) {

            $user = $hod->user;
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $hod->update([
                'dept_id' => $request->dept_id,
                'username' => $request->username,
                'year' => $request->year,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('admin.dashboard')->with('success', 'HoD account updated successfully.');
    }


    public function thesisDetails(Thesis $thesis)
    {
        $thesis->load(['user', 'department', 'hod']);
        return view('admin.thesisDetails', compact('thesis'));
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
