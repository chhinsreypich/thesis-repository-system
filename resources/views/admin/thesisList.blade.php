<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-bold text-dark m-0">
                All Theses
            </h2>

            {{-- search --}}
            <form method="GET" action="{{ route('admin.thesisList') }}">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search title, department, year, abstract, or posted by..."
                    class="form-control search-input">
            </form>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">

            @if (session('error'))
                <div class="alert alert-danger shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row g-3">
                @foreach ($theses as $thesis)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('admin.thesisDetails', $thesis->id) }}" class="thesis-link">
                            <div class="card border-0 shadow-sm h-100 thesis-card">

                                <div class="image-wrapper">
                                    @if ($thesis->image)
                                        <img src="{{ asset('storage/' . $thesis->image) }}" alt="{{ $thesis->title }}">
                                    @else
                                        <img src="https://via.placeholder.com/400x200?text=No+Image" alt="No Image">
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">

                                    <h6 class="title">
                                        {{ $thesis->title }}
                                    </h6>

                                    <p class="meta">
                                       {{ $thesis->department->name }}
                                    </p>

                                    <p class="meta mb-0">
                                        {{-- <strong>Year:</strong> --}}
                                        {{ \Carbon\Carbon::parse($thesis->submission_date)->format('Y') }}
                                    </p>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $theses->links() }}
            </div>

        </div>
    </div>

    <style>
        .search-input {
            min-width: 450px;
            border-radius: 6px;
            font-size: 14px;
        }

        .search-input:focus {
            border-color: #ced4da;
            box-shadow: none;
        }

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
        .thesis-link:hover {
            cursor: pointer;
        }

        .card img {
            border-radius: 12px 12px 0 0;
        }
    </style>

</x-app-layout>






