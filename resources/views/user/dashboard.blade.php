<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="fw-bold text-dark m-0">
                    {{ Auth::user()->name }}
                </h2>
            </div>
        </div>
    </x-slot>


    <div class="py-4">
        <div class="container">

            @if (session('error'))
                <div class="alert alert-danger shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row g-4">

                <div class="row g-4 mb-4">

                    <div class="stats">
                        <div class="stat-card">
                            <p>Department</p>
                            <p style="color: #111827; margin-top: 9px;">{{ auth()->user()->student->department->name }}
                            </p>
                        </div>

                        <div class="stat-card">
                            <p>Total Theses in This Dept</p>
                            <h2>{{ $deptTheses }}</h2>
                        </div>

                        <div class="stat-card">
                            <p>Total Theses</p>
                            <h2>{{ $totalTheses }}</h2>
                        </div>

                        <div class="stat-card">
                            <p>Owner Joined on</p>
                            <h2>{{ $joinedYear }}</h2>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">
                        {{ $theses->first()->department->name ?? 'Department' }}
                    </h5>

                    <div class="row g-3">
                        @forelse ($theses as $thesis)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <a href="{{ route('user.thesisDetails', $thesis->id) }}" class="thesis-link">

                                    <div class="card border-0 shadow-sm h-100 thesis-card">

                                        <div class="bg-light d-flex justify-content-center align-items-center"
                                            style="height: 200px;">
                                            @if ($thesis->image)
                                                <img src="{{ asset('storage/' . $thesis->image) }}"
                                                    style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                            @else
                                                <img src="https://via.placeholder.com/400x200?text=No+Image"
                                                    style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                            @endif
                                        </div>

                                        <div class="card-body d-flex flex-column">
                                            <h6 class="fw-bold text-dark mb-2 text-truncate">
                                                {{ $thesis->title }}
                                            </h6>

                                            <p class="text-muted small mb-1">
                                                {{ $thesis->department->name }}
                                            </p>

                                            <p class="text-muted small mb-0">
                                                {{ \Carbon\Carbon::parse($thesis->submission_date)->format('Y') }}
                                            </p>
                                        </div>

                                    </div>
                                </a>
                            </div>

                        @empty
                            <div class="col-12 text-center py-4 text-muted">
                                No theses available in your department.
                            </div>
                        @endforelse
                        <div class="text-center mt-4">
                            <a href="{{ route('user.allThesis') }}" class="btn btn-outline-primary px-4">
                                View More
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <style>
            .stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 20px;
            }

            .stat-card {
                background: #ffffff;
                padding: 20px;
                border-radius: 10px;
                border: 1px solid #e5e7eb;
            }

            .stat-card p {
                font-size: 16px;
                color: #6b7280;
            }

            .stat-card h2 {
                margin-top: 8px;
                font-size: 24px;
                font-weight: 600;
                color: #111827;
            }

            .thesis-card {
                border-radius: 12px;
                transition: all 0.2s ease-in-out;
            }

            .thesis-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            .card img {
                border-radius: 10px 10px 0 0;
            }
        </style>
</x-app-layout>

