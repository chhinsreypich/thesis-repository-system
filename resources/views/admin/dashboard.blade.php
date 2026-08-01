<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-semibold text-dark m-0">
                All HoD Accounts
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">

            <div class="row g-4 mb-4">

                <div class="stats">
                    <div class="stat-card">
                        <p>Total Hod</p>
                        <h2>{{ $totalHod }}</h2>
                    </div>

                    <div class="stat-card">
                        <p>Active Hod</p>
                        <h2>{{ $activeHod }}</h2>
                    </div>
                    
                    <div class="stat-card">
                        <p>Total Theses</p>
                        <h2>{{ $totalThesis }}</h2>
                    </div>
                </div>

            </div>

            <h5 class="fw-bold mb-4">Hod Account</h5>
            <div class="card clean-card mb-4">
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Year</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($hods as $hod)
                                <tr>
                                    <td class="fw-medium">{{ $hod->user->name }}</td>
                                    <td class="text-muted">{{ $hod->username }}</td>
                                    <td class="text-muted">{{ $hod->user->email }}</td>
                                    <td>{{ $hod->department->name }}</td>
                                    <td>{{ $hod->year }}</td>

                                    <td>
                                        <span
                                            class="badge status-badge 
                                            {{ $hod->status == 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                            {{ ucfirst($hod->status) }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <a href="{{ route('admin.editHod', $hod->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No HoD accounts found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <h5 class="fw-bold mb-3">Theses</h5>

            <div class="row g-3">
                @foreach ($theses as $thesis)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('admin.thesisDetails', $thesis->id) }}" class="thesis-link">
                            <div class="card border-0 shadow-sm h-100 thesis-card">

                                <div class="image-wrapper">
                                    @if ($thesis->image)
                                        <img src="{{ asset('storage/' . $thesis->image) }}"
                                            alt="{{ $thesis->title }}">
                                    @else
                                        <img src="https://via.placeholder.com/400x200?text=No+Image" alt="No Image">
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h6 class="title">{{ $thesis->title }}</h6>

                                    <p class="meta"><strong>Department:</strong> {{ $thesis->department->name }}</p>
                                    <p class="meta mb-0">
                                        <strong>Year:</strong>
                                        {{ \Carbon\Carbon::parse($thesis->submission_date)->format('Y') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
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
        /* ===== CLEAN TABLE CARD ===== */
        .clean-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        table thead {
            background-color: #f9fafb;
        }

        table th {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        table td {
            font-size: 14px;
            padding: 12px 10px;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 10px;
            font-weight: 500;
        }

        /* ===== BUTTON ===== */
        .btn-outline-primary {
            font-size: 13px;
            padding: 4px 10px;
        }

        /* ===== KEEP YOUR OLD THESIS STYLE ===== */
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
    </style>

</x-app-layout>
