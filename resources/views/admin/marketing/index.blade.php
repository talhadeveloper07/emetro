@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('e_admin.index') }}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg></a>
                        Marketing
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                    <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                      <path d="M12 5l0 14"></path>
                      <path d="M5 12l14 0"></path>
                    </svg>Create Media Assets</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                    <div class="">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
                            <div class="col col_1">
                                <a class="w-100" href="{{route('e_admin.marketing.brochures')}}" >
                                    <div class="dashboard-card">
                                        <svg class="svg-inline--fa fa-book" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="book" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"></path></svg>              
                                        <h5>Brochures</h5>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a class="w-100" href="{{route('e_admin.marketing.presentations')}}" >
                                    <div class="dashboard-card">
                                        <svg class="svg-inline--fa fa-bullhorn" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bullhorn" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M480 32c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9L381.7 53c-48 48-113.1 75-181 75l-8.7 0-32 0-96 0c-35.3 0-64 28.7-64 64l0 96c0 35.3 28.7 64 64 64l0 128c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32l0-128 8.7 0c67.9 0 133 27 181 75l43.6 43.6c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6l0-147.6c18.6-8.8 32-32.5 32-60.4s-13.4-51.6-32-60.4L480 32zm-64 76.7L416 240l0 131.3C357.2 317.8 280.5 288 200.7 288l-8.7 0 0-96 8.7 0c79.8 0 156.5-29.8 215.3-83.3z"></path></svg>
                                        <h5>Product Presentations</h5>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a class="w-100" href="{{route('e_admin.marketing.images')}}" >
                                    <div class="dashboard-card">
                                        <svg class="svg-inline--fa fa-images" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="images" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M160 32c-35.3 0-64 28.7-64 64l0 224c0 35.3 28.7 64 64 64l352 0c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L160 32zM396 138.7l96 144c4.9 7.4 5.4 16.8 1.2 24.6S480.9 320 472 320l-144 0-48 0-80 0c-9.2 0-17.6-5.3-21.6-13.6s-2.9-18.2 2.9-25.4l64-80c4.6-5.7 11.4-9 18.7-9s14.2 3.3 18.7 9l17.3 21.6 56-84C360.5 132 368 128 376 128s15.5 4 20 10.7zM192 128a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120L0 344c0 75.1 60.9 136 136 136l320 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-320 0c-48.6 0-88-39.4-88-88l0-224z"></path></svg>
                                        <h5>Images</h5>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a class="w-100" href="{{route('e_admin.marketing.logos')}}" >
                                    <div class="dashboard-card">
                                        <svg class="svg-inline--fa fa-infinity pb-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="infinity" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg=""><path fill="currentColor" d="M0 241.1C0 161 65 96 145.1 96c38.5 0 75.4 15.3 102.6 42.5L320 210.7l72.2-72.2C419.5 111.3 456.4 96 494.9 96C575 96 640 161 640 241.1l0 29.7C640 351 575 416 494.9 416c-38.5 0-75.4-15.3-102.6-42.5L320 301.3l-72.2 72.2C220.5 400.7 183.6 416 145.1 416C65 416 0 351 0 270.9l0-29.7zM274.7 256l-72.2-72.2c-15.2-15.2-35.9-23.8-57.4-23.8C100.3 160 64 196.3 64 241.1l0 29.7c0 44.8 36.3 81.1 81.1 81.1c21.5 0 42.2-8.5 57.4-23.8L274.7 256zm90.5 0l72.2 72.2c15.2 15.2 35.9 23.8 57.4 23.8c44.8 0 81.1-36.3 81.1-81.1l0-29.7c0-44.8-36.3-81.1-81.1-81.1c-21.5 0-42.2 8.5-57.4 23.8L365.3 256z"></path></svg>
                                        <h5>Logos</h5>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a class="w-100" href="{{route('e_admin.marketing.videos')}}" >
                                    <div class="dashboard-card">
                                        <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64l256 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2l0 256c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1l0-17.1 0-128 0-17.1 14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path></svg>
                                        <h5>Videos</h5>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>

<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New Media Assest</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
