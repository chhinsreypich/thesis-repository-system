<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold text-dark m-0">
            Request Thesis Upload
        </h2>
    </x-slot>

    <div class="container mt-4" style="max-width: 700px;">
        <div class="card shadow-sm border-0 compact-card p-3">

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.requestStore') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <label class="form-label small">Title</label>
                    <input type="text" name="title" class="form-control form-control-sm"
                        value="{{ old('title') }}" required>
                </div>

                <div class="mb-2">
                    <label class="form-label small">Abstract</label>
                    <textarea name="abstract" class="form-control form-control-sm" rows="3" required>{{ old('abstract') }}</textarea>
                </div>

                <div class="mb-2">
                    <label class="form-label small">Description</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-2">
                    <label class="form-label small">Submission Date</label>
                    <input type="date" name="submission_date" class="form-control form-control-sm" required>
                </div>

                <div class="mb-2">
                    <label class="form-label small">Image (optional)</label>
                    <input type="file" name="image" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label small">Thesis PDF</label>
                    <input type="file" name="thesis_file" class="form-control form-control-sm" required>
                </div>

                <button type="submit" class="btn btn-success btn-sm w-100">
                    Send Request
                </button>
            </form>

            
        </div>
    </div>



    <style>
        .status-badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 10px;
            font-weight: 500;
        }

        .compact-card {
            border-radius: 10px;
            background: #fff;
        }

        .compact-card .form-label {
            font-size: 0.85rem;
            color: #374151;
        }

        .compact-card .form-control {
            font-size: 0.85rem;
            padding: 6px 10px;
        }

        .compact-card button {
            font-size: 0.9rem;
            padding: 6px 12px;
        }
    </style>
</x-app-layout>


