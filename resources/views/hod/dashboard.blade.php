<x-app-layout>
    <div class="py-4">
        <div class="container">

            <h5 class="fw-bold mb-4">In My Department</h5>
            <div class="row g-4 mb-4">

                <div class="stats">
                    <div class="stat-card">
                        <p>Total Theses</p>
                        <h2>{{ $totalTheses }}</h2>
                    </div>

                    <div class="stat-card">
                        <p>Pending Requests</p>
                        <h2>{{ $pendingRequests }}</h2>
                    </div>

                    <div class="stat-card">
                        <p>Approved</p>
                        <h2>{{ $approvedRequests }}</h2>
                    </div>

                    <div class="stat-card">
                        <p>Owner Joined on</p>
                        <h2>{{ $joinedYears }}</h2>
                    </div>
                </div>

            </div>

            <h5 class="fw-bold mb-3">Latest Theses</h5>
            <div class="row g-3">
                @foreach ($theses as $thesis)
                    <div class="col-lg-3 col-md-4 col-sm-6">

                        <a href="{{ route('hod.thesisDetails', $thesis->id) }}" class="thesis-link">
                            <div class="card thesis-card h-100">

                                <div class="image-wrapper">
                                    @if ($thesis->image)
                                        <img src="{{ asset('storage/' . $thesis->image) }}" alt="{{ $thesis->title }}">
                                    @else
                                        <img src="https://via.placeholder.com/400x200?text=No+Image">
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column p-3">

                                    <h6 class="title">
                                        {{ $thesis->title }}
                                    </h6>

                                    <p class="meta">
                                        {{ $thesis->department->name }}
                                    </p>

                                    <p class="meta mb-0">
                                        {{ \Carbon\Carbon::parse($thesis->submission_date)->format('Y') }}
                                    </p>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-5">
                <h5 class="fw-bold mb-3">Recent Thesis Requests (All Departments)</h5>

                <div class="card clean-card p-3">

                    @if ($requests->count())
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 clean-table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Student</th>
                                        <th>Department</th>
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
                                                {{ $req->user->name }}
                                            </td>

                                            <td class="small text-muted">
                                                {{ $req->department->name }}
                                            </td>

                                            <td class="small text-muted">
                                                {{ \Carbon\Carbon::parse($req->submission_date)->format('Y-m-d') }}
                                            </td>

                                            <td>
                                                <span
                                                    class="badge status-badge
                                        @if ($req->status == 'pending') pending
                                        @elseif($req->status == 'approved') approved
                                        @else rejected @endif">
                                                    {{ ucfirst($req->status ?? '-') }}
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
                border: 1px solid #e5e7eb;
                transition: 0.3s ease;
                background: #fff;
            }

            .thesis-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            }

            .image-wrapper {
                height: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f9fafb;
                border-bottom: 1px solid #f1f1f1;
            }

            .image-wrapper img {
                max-height: 100%;
                max-width: 100%;
                object-fit: contain;
            }

            .card-body {
                flex: 1 1 auto;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 16px;
            }

            .title {
                font-size: 16px;
                font-weight: 600;
                color: #111827;
                margin-bottom: 8px;

                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                min-height: 44px;
            }

            .meta {
                font-size: 12px;
                color: #6b7280;
                margin: 0;
            }

            .thesis-link {
                text-decoration: none;
                color: inherit;
                display: block;
            }

            .thesis-link:hover {
                cursor: pointer;
            }

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
