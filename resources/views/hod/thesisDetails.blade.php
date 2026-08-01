<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Thesis Details
        </h2>
    </x-slot>


    <div class="container mt-5">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card shadow">
            <div class="row g-0">
                <div class="col-md-4">
                    @if ($thesis->image)
                        <img src="{{ asset('storage/' . $thesis->image) }}" class="img-fluid rounded-start"
                            alt="Thesis Image">
                    @else
                        <img src="{{ asset('images/default.png') }}" class="img-fluid rounded-start" alt="No Image">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="card-body d-flex flex-column h-100">
                        <h3 class="card-title fw-bold" style="font-size: 32px">{{ $thesis->title }}</h3>
                        <p class="mb-1"><strong>Department:</strong> {{ $thesis->department->name }}</p>
                        <p class="mb-1"><strong>Posted By:</strong> {{ $thesis->user->name }}</p>
                        <p class="mb-1"><strong>Verified By (HoD):</strong> {{ $thesis->hod->user->name ?? ' ' }}</p>
                        <p class="mb-1"><strong>Submission Date:</strong> {{ $thesis->submission_date }}</p><br>
                        <p class="mb-1"><strong>Abstract:</strong></p>
                        <p style="font-size: 16px;">{{ $thesis->abstract }}</p><br>
                        <p class="mb-1"><strong>Description:</strong></p>
                        <p style="font-size: 16px;">{{ $thesis->description }}</p><br>


                        <div class="mt-auto d-flex justify-content-end">
                            {{-- go back to the previous page --}}
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Back</a>

                            <a href="{{ route('hod.viewPDF', $thesis->id) }}" target="_blank"
                                class="btn btn-success me-4">
                                View PDF
                            </a>


                            @php
                                $userDeptId = auth()->user()->hod->dept_id ?? null;
                            @endphp

                            @if ($userDeptId === $thesis->dept_id)
                                {{-- if user dept_id is the same as the thesis dept_id  -> show 2 buttons --}}
                                <a href="{{ route('hod.editThesis', $thesis->id) }}" class="btn btn-primary me-2">
                                    Edit
                                </a>

                                <form action="{{ route('hod.deleteThesis', $thesis->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this thesis?');">
                                        Delete
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
