<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Thesis Details
        </h2>
    </x-slot>

    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow">
            <div class="row g-0">
                
                <div class="col-md-4">
                    @if ($thesis->image)
                        <img src="{{ asset('storage/' . $thesis->image) }}" class="img-fluid rounded-start" alt="Thesis Image">
                    @else
                        <img src="{{ asset('images/default.png') }}" class="img-fluid rounded-start" alt="No Image">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="card-body d-flex flex-column h-100">
                        <h3 class="card-title fw-bold" style="font-size: 28px;">{{ $thesis->title }}</h3>

                        <p class="mb-1"><strong>Department:</strong> {{ $thesis->department->name }}</p>
                        <p class="mb-1"><strong>Posted By:</strong> {{ $thesis->user->name }}</p>
                        <p class="mb-1"><strong>Verified By (HoD):</strong> {{ $thesis->hod->user->name ?? '-' }}</p>
                        <p class="mb-1"><strong>Submission Date:</strong> {{ $thesis->submission_date }}</p>

                        <hr>

                        <p class="mb-1"><strong>Abstract:</strong></p>
                        <p style="font-size: 16px;">{{ $thesis->abstract }}</p>

                        <p class="mb-1 mt-3"><strong>Description:</strong></p>
                        <p style="font-size: 16px;">{{ $thesis->description }}</p>

                        <div class="mt-auto d-flex flex-wrap justify-content-end gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>

                            <a href="{{ route('admin.viewPDF', $thesis->id) }}" target="_blank" class="btn btn-success">
                                View PDF
                            </a>

                            <form action="{{ route('admin.downloadPDF', $thesis->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Download PDF</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-body p {
            line-height: 1.5;
        }

        .card-body hr {
            margin: 1rem 0;
            border-top: 1px solid #e5e7eb;
        }

        .card-body .btn {
            font-size: 0.875rem;
            padding: 6px 12px;
        }
    </style>
</x-app-layout>