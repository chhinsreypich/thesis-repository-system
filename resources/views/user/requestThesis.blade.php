<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-semibold text-dark m-0">
                Request Thesis Upload
            </h2>

            <a href="{{ route('user.createRequest') }}" class="btn btn-primary btn-sm">
                + Create Request
            </a>
        </div>
    </x-slot>

    <div class="container mt-4" style="max-width: 1000px;">
        <div class="card clean-card p-3">

            <h6 class="fw-semibold mb-3 text-dark">Your Requests</h6>

            @if ($requests->count())
                <div class="table-responsive">
                    <table class="table align-middle mb-0 clean-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($requests as $req)
                                <tr>
                                    <td class="fw-medium small">
                                        {{ $req->title }}
                                    </td>
                              
                                    <td class="small text-muted">
                                        {{ \Carbon\Carbon::parse($req->submission_date)->format('Y-m-d') }}
                                    </td>

                                    <td>
                                        <span class="badge status-badge
                                            @if ($req->status == 'pending') pending
                                            @elseif($req->status == 'approved') approved
                                            @else rejected
                                            @endif">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4 small">
                    No requests found
                </div>
            @endif

        </div>
    </div>

    <style>
        .clean-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        .clean-table thead {
            background-color: #f9fafb;
        }

        .clean-table th {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .clean-table td {
            font-size: 14px;
            padding: 12px 8px;
        }

        .status-badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 10px;
            font-weight: 500;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        }

        .approved {
            background: #d1e7dd;
            color: #0f5132;
        }

        .rejected {
            background: #f8d7da;
            color: #842029;
        }
    </style>
</x-app-layout>






{{-- <x-app-layout>
    <x-slot name="header">
        <h2>Request Thesis Upload</h2>
    </x-slot>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('user.requestStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Abstract</label>
                        <textarea name="abstract" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Submission Date</label>
                        <input type="date" name="submission_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Thesis PDF</label>
                        <input type="file" name="thesis_file" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Send Request</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> --}}
