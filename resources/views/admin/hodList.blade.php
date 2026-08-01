<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-semibold text-dark m-0">
                HoD Management
            </h2>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.hodList') }}">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search name, email, department..." class="form-control search-input">
            </form>

            <a href="{{ route('admin.createHod') }}" class="btn btn-sm btn-primary ms-2">
                + Create HoD
            </a>
        </div>
    </x-slot>

    <div class="container mt-4">

        <div class="card clean-card">
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
                                <td class="fw-medium">{{ $hod->user->name  }}</td>
                                <td class="text-muted">{{ $hod->username }}</td>
                                <td class="text-muted">{{ $hod->user->email  }}</td>
                                <td>{{ $hod->department->name }}</td>
                                <td>{{ $hod->year }}</td>

                                <td>
                                    <span
                                        class="badge status-badge 
                                        {{ $hod->status == 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ ucfirst($hod->status ) }}
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

        <div class="mt-3">
            {{ $hods->links() }}
        </div>

    </div>

    <style>
        /* ===== CARD ===== */
        .clean-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        /* ===== TABLE ===== */
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

        .search-input {
            min-width: 400px;
            max-width: 440px;
            border-radius: 8px;
            font-size: 14px;
            padding: 6px 12px;
        }

        .search-input:focus {
            border-color: #ced4da;
            box-shadow: none;
        }

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
    </style>

</x-app-layout>
