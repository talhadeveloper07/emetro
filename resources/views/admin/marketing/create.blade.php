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
                                 class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M15 6l-6 6l6 6"/>
                            </svg>
                        </a>
                        Back To Marketing Page
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('e_admin.marketing.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y">

                                <!-- Title -->
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" placeholder="Enter asset title"
                                           value="{{ old('title') }}" class="form-control" required>
                                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <!-- Description (Rich Text Editor) -->
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea id="editor" name="description" placeholder="Enter description" rows="6"
                                              class="form-control">{{ old('description') }}</textarea>
                                    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <!-- Content Type -->
                                <div class="mb-3">
                                    <label class="form-label">Select Type</label>
                                    <select name="content_type" class="form-select" required>
                                        <option value="">-- Select Type --</option>
                                        @foreach(['logo','brochure','image','video','presentation'] as $type)
                                            <option value="{{ $type }}" {{ old('content_type') == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('content_type') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <!-- Document -->
                                <div class="mb-3">
                                    <label class="form-label">Upload Document</label>
                                    <input type="file" name="document" class="form-control" required>
                                    @error('document') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label">Upload Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-20">
                                        Save Media Asset
                                    </button>
                                    <a href="{{ route('e_admin.marketing.index') }}" class="btn btn-secondary mx-2 w-20">
                                        Cancel
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- CKEditor 5 (No Image Upload) -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
      
    </script>
@endpush
