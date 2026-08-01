<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-bold text-dark m-0">
                Thesis Upload Requests from Students
            </h2>

        </div>
    </x-slot>

    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @forelse ($requests as $req)
    <div class="card shadow" style="margin-bottom: 40px;">
        <div class="row g-0">
            <div class="col-md-4">
                @if ($req->image)
                    <img src="{{ asset('storage/' . $req->image) }}" class="img-fluid rounded-start"
                        alt="{{ $req->title }}">
                @else
                    <img src="https://via.placeholder.com/400x200?text=No+Image" class="img-fluid rounded-start"
                        alt="No Image">
                @endif
            </div>

            <div class="col-md-8">
                <div class="card-body d-flex flex-column h-100">
                    <h3 class="card-title fw-bold" style="font-size: 32px">{{ $req->title }}</h3>
                    <p class="mb-1"><strong>Department:</strong> {{ $req->department->name }}</p>
                    <p class="mb-1"><strong>Posted By:</strong> {{ $req->user->name }}</p>
                    <p class="mb-1"><strong>Verified By (HoD):</strong>
                        {{ $req->hod->user->name }}
                    </p>
                    <p class="mb-1"><strong>Submission Date:</strong> {{ $req->submission_date }}</p>

                    <br>

                    <p class="mb-1"><strong>Abstract:</strong></p>
                    <p style="font-size: 16px;">{{ $req->abstract }}</p>

                    <br>

                    <p class="mb-1"><strong>Description:</strong></p>
                    <p style="font-size: 16px;">{{ $req->description }}</p>

                    <div class="mt-auto pt-3">
                        <a href="{{ route('hod.viewRequestPDF', $req->id) }}" target="_blank"
                            class="btn btn-sm mb-2 btn-outline-secondary me-2">
                            View PDF
                        </a>

                        <div class="d-flex gap-2">
                            <form action="{{ route('hod.requestsApprove', $req->id) }}" method="POST" class="w-100">
                                @csrf
                                <button class="btn btn-success w-100 btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('hod.requestsReject', $req->id) }}" method="POST" class="w-100">
                                @csrf
                                <button class="btn btn-danger w-100 btn-sm">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@empty
    <div class="text-center py-5">
        <h5 class="text-muted">No requests found</h5>
        <p class="text-muted small">There are currently no thesis upload requests.</p>
    </div>
@endforelse
    </div>

    <style>
        .request-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .request-img {
            height: 100%;
            object-fit: cover;
            border-radius: 12px 0 0 12px;
        }
        .title {
            font-size: 24px;
            color: #111827;
            margin-bottom: 10px;
        }

        .meta {
            font-size: 13px;
            color: #4b5563;
            margin-bottom: 4px;
        }

        .section-label {
            font-size: 14px;
            margin-bottom: 4px;
            color: #111827;
        }
        .text-content {
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
        }
    </style>

</x-app-layout>



















