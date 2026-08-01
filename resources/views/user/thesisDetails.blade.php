<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Thesis Details
        </h2>
    </x-slot>

    <div class="container mt-5">
        {{-- @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif --}}
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
                        <p class="mb-1"><strong>Verified By (HoD):</strong> {{ $thesis->hod->user->name ?? ' '  }}</p>
                        <p class="mb-1"><strong>Submission Date:</strong> {{ $thesis->submission_date }}</p><br>
                        <p class="mb-1"><strong>Abstract:</strong></p>
                        <p style="font-size: 18px;">{{ $thesis->abstract }}</p><br>
                        <p class="mb-1"><strong>Description:</strong></p>
                        <p style="font-size: 18px;">{{ $thesis->description }}</p>


                        <div class="mt-auto d-flex justify-content-end">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary me-2">Back</a>

                            <a href="{{ route('user.viewPDF', $thesis->id) }}" target="_blank"
                                class="btn btn-success me-4">
                                View PDF
                            </a>

                            {{-- <a href="{{ route('user.downloadPDF', $thesis->id) }}" class="btn btn-success">Download PDF</a> --}}
                            <form action="{{ route('user.downloadPDF', $thesis->id) }}" method="POST">
                                @csrf
                                <button onclick="downloadPDF({{ $thesis->id }})">Download PDF</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div>
    <script>
        function downloadPDF(id) {
            fetch('/user/thesis/' + id + '/download', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'thesis.pdf';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                });
        }
    </script> --}}
</x-app-layout>
