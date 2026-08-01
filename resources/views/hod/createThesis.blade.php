<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Upload Thesis') }}
        </h2>
    </x-slot>

    <div class="container mt-4" style="max-width: 700px;">
        <div class="card shadow-sm border-0 compact-card p-3">

            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('hod.storeThesis') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <label for="title" class="form-label small">Thesis Title</label>
                    <input type="text" name="title" id="title" class="form-control form-control-sm"
                        value="{{ old('title') }}" required>
                </div>

                <div class="mb-2">
                    <label for="abstract" class="form-label small">Abstract</label>
                    <textarea name="abstract" id="abstract" class="form-control form-control-sm" rows="3" required>{{ old('abstract') }}</textarea>
                </div>

                <div class="mb-2">
                    <label for="description" class="form-label small">Description</label>
                    <textarea name="description" id="description" class="form-control form-control-sm" rows="3" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-2">
                    <label for="submission_date" class="form-label small">Submission Date</label>
                    <input type="date" name="submission_date" id="submission_date" class="form-control form-control-sm" required>
                </div>

                <div class="mb-2">
                    <label for="image" class="form-label small">Image</label>
                    <input type="file" id="image" name="image" class="form-control form-control-sm" required>
                </div>

                <div class="mb-3">
                    <label for="thesis_file" class="form-label small">Thesis File (PDF)</label>
                    <input type="file" id="thesis_file" name="thesis_file" class="form-control form-control-sm" required>
                </div>

                <button type="submit" class="btn btn-success btn-sm w-100">
                    Upload Thesis
                </button>
            </form>
        </div>
    </div>

    <style>
        .compact-card {
            border-radius: 10px;
            padding: 20px;
            background: #fff;
        }

        .compact-card .form-label {
            font-size: 0.875rem; 
        }

        .compact-card .form-control {
            font-size: 0.875rem; 
            padding: 4px 10px;
        }

        .compact-card button {
            font-size: 0.875rem;
            padding: 6px 12px;
        }
    </style>
</x-app-layout>


