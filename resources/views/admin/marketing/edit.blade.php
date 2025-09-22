@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <a href="{{ route('e_admin.marketing.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icon-tabler-chevron-left">
                             <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                             <path d="M15 6l-6 6l6 6"/>
                        </svg>
                    </a>
                    Edit Media Asset
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="card w-100">
                <div class="card-body">
                    <form action="{{ route('e_admin.marketing.update', $marketing->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" 
                                   value="{{ old('title', $marketing->title) }}" required>
                            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $marketing->description) }}</textarea>
                            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Content Type -->
                        <div class="mb-3">
                            <label class="form-label">Select Type</label>
                            <select name="content_type" class="form-select" required>
                                <option value="">-- Select Type --</option>
                                @foreach(['logo','brochure','image','video','presentation'] as $type)
                                    <option value="{{ $type }}" {{ old('content_type', $marketing->content_type) == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('content_type') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Document -->
                        <div class="mb-3">
                            <label class="form-label">Upload Document</label>
                            <input type="file" name="document" class="form-control">
                            @if($marketing->document)
                                <a href="{{ asset('storage/'.$marketing->document) }}" target="_blank" class="mt-1 d-block">Current document</a>
                            @endif
                            @error('document') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($marketing->image)
                                <img src="{{ asset('storage/'.$marketing->image) }}" alt="Current Image" class="mt-2" style="max-height:60px;">
                            @endif
                            @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4 d-flex">
                            <button type="submit" class="btn btn-primary w-20">Update Media Asset</button>
                            <a href="{{ route('e_admin.marketing.index') }}" class="btn btn-secondary mx-2 w-20">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
