<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit HoD Account') }}
        </h2>
    </x-slot>

    <div class="container mt-4" style="max-width: 800px;">
        <div class="card shadow-sm border-0 compact-card p-3">

            @if ($errors->any())
                <div class="alert alert-danger mb-3 small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.updateHod', $hod->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label small">Username</label>
                        <input type="text" name="username" id="username" class="form-control form-control-sm" value="{{ $hod->username }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label small">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $hod->user->name }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label small">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-sm" value="{{ $hod->user->email }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="dept_id" class="form-label small">Department</label>
                        <select name="dept_id" id="dept_id" class="form-select form-select-sm" required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $hod->dept_id == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="year" class="form-label small">Year</label>
                        <input type="number" name="year" id="year" class="form-control form-control-sm" value="{{ $hod->year }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label small">Status</label>
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="active" {{ $hod->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $hod->status == 'inactive' ? 'selected' : '' }}>Terminate</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-sm w-100 mt-3">
                    Update HoD Account
                </button>
            </form>
        </div>
    </div>

    <style>
        .compact-card {
            border-radius: 10px;
            background: #fff;
        }

        .compact-card .form-label {
            font-size: 0.875rem;
        }

        .compact-card .form-control,
        .compact-card .form-select {
            font-size: 0.875rem;
            padding: 4px 10px;
        }

        .compact-card button {
            font-size: 0.875rem;
            padding: 6px 12px;
        }
    </style>
</x-app-layout>