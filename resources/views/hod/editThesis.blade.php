<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Thesis') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="card shadow">

            <div class="card-body">
                <form action="{{ route('hod.updateThesis', $thesis->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Thesis Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ $thesis->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="abstract" class="form-label">Abstract</label>
                        <textarea name="abstract" id="abstract" class="form-control" required>{{ $thesis->abstract }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" required>{{ $thesis->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="submission_date" class="form-label">Submission Date</label>
                        <input type="date" name="submission_date" id="submission_date" class="form-control"
                            value="{{ $thesis->submission_date }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control"><br>
                    </div>

                    <div class="mb-3">
                        <label for="thesis_file" class="form-label">Thesis File (PDF)</label>
                        <input type="file" id="thesis_file" name="thesis_file" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success">
                        Update Thesis
                    </button>
                </form>
            </div>
        </div>
    </div>
    
</x-app-layout>
