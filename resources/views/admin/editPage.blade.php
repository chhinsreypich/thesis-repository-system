<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Page') }}
            </h2>

        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
           
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hods as $hod)
                            <tr>
                                <td>{{ $hod->user->name }}</td>
                                <td>{{ $hod->username }}</td>
                                <td>{{ $hod->user->email }}</td>
                                <td>{{ $hod->department->name }}</td>
                                <td>{{ $hod->year }}</td>
                                <td>{{ ucfirst($hod->status) }}</td> {{--  make the first letter uppercase --}}
                                <td>
                                    <a href="{{ route('admin.editHod', $hod->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
    {{-- {{ $theses->links() }} --}}

    <div class="d-flex justify-content-between align-items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Theses') }}
    </h2>

    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif --}}

            <div class="row g-4">
                @foreach ($theses as $thesis)
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            @if ($thesis->image)
                                <img src="{{ asset('storage/' . $thesis->image) }}" class="card-img-top"
                                    style="height: 150px; object-fit: contain; background-color: #f8f9fa;"
                                    alt="{{ $thesis->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top"
                                    alt="No Image">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <p class="card-title fw-bold" style="font-size: 32px">{{ $thesis->title }}</p>
                                <p class="card-text mb-1"><strong>Department:</strong> {{ $thesis->department->name }}
                                </p>
                                <p class="card-text mb-2"><strong>Year:</strong>
                                    {{ \Carbon\Carbon::parse($thesis->submission_date)->format('Y') }}</p>

                                <div class="mt-auto">
                                    <a href="{{ route('admin.thesisDetails', $thesis->id) }}"
                                        class="btn btn-sm btn-success w-100">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    {{ $theses->links() }}
</x-app-layout>
