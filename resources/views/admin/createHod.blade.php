<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Create HoD Account') }}
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

            <form action="{{ route('admin.storeHod') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label small">Username</label>
                        <input type="text" name="username" id="username" class="form-control form-control-sm" value="{{ old('username') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label small">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label small">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-sm" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="dept_id" class="form-label small">Department</label>
                        <select name="dept_id" id="dept_id" class="form-select form-select-sm" required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label small">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-sm" required>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label small">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-sm" required>
                    </div>

                    <div class="col-md-6">
                        <label for="year" class="form-label small">Year</label>
                        <input type="number" name="year" id="year" class="form-control form-control-sm" required>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label small">Status</label>
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="active">Active</option>
                            <option value="inactive">Terminate</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-sm w-100 mt-3">
                    Create HoD Account
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
