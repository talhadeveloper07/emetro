@extends('layouts.admin')

@section('content')
<div class="container-xl">
    <!-- Page Header -->
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <a href="{{ route('e_admin.marketing.index') }}" class="text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icon-tabler-chevron-left me-1">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M15 6l-6 6l6 6"/>
                        </svg>
                    </a>
                    Brochures
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <!-- Create New Button -->
                <button class="btn btn-primary" onclick="openCreateModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icon-tabler-plus me-1">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Add New Brochure
                </button>
            </div>
        </div>
    </div>
    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Media Grid -->
    <div class="page-body" id="column-body">
        <div class="container-xl">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @forelse($brochures as $brochure)
                    <div class="col position-relative">
                        <a href="{{ $brochure->document ? asset('storage/'.$brochure->document) : ($brochure->brochure ? asset('storage/'.$brochure->brochure) : '#') }}" 
                           target="_blank" 
                           class="text-decoration-none text-dark w-100">

                            <div class="marketing border rounded shadow-sm p-2 d-flex align-items-center hover-shadow">
                                {{-- Thumbnail --}}
                                <div class="w-30" style="width:30%;">
                                    @if($brochure->image)
                                        <img src="{{ asset('storage/'.$brochure->image) }}" alt="thumbnail" class="rounded" style="width:100%;">
                                    @elseif($brochure->image)
                                        <span class="badge bg-secondary">Doc</span>
                                    @endif
                                </div>

                                {{-- Details --}}
                                <div class="ms-2 w-70" style="width:70%;">
                                    <h5 class="mb-1 text-start">{{ $brochure->title }}</h5>
                                    <p class="text-muted mb-0" style="font-size:12px;">{{ $brochure->description }}</p>
                                </div>
                            </div>
                        </a>

                        <!-- Edit -->
                        <button class="btn btn-link p-0 m-0" 
                            onclick="openEditbrochureModal(
                                {{ $brochure->id }},
                                '{{ addslashes($brochure->title) }}',
                                '{{ addslashes($brochure->description) }}',
                                '{{ $brochure->content_type }}',
                                '{{ $brochure->image ? asset('storage/'.$brochure->image) : '' }}',
                                '{{ $brochure->document ? asset('storage/'.$brochure->document) : '' }}'
                            )">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="icon icon-tabler icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                        </button>

                        <!-- Delete -->
                        <button class="btn btn-link p-0 m-0 delete" 
                            onclick="openDeleteModal({{ $brochure->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="icon icon-tabler icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7h16" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7V4h6v3" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p>No media found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create/Edit Media -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="mediaForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitleText">Add New Brochure</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Title -->
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" id="mediaTitle" class="form-control" required>
          </div>

          <!-- Description -->
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" id="mediaDescription" class="form-control" rows="4"></textarea>
          </div>

          <!-- Content Type -->
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="content_type" id="mediaContentType" class="form-select">
              @foreach(['logo','image','brochure','video','presentation'] as $type)
                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
              @endforeach
            </select>
          </div>

          <!-- Document Upload -->
          <div class="mb-3">
            <label class="form-label">Upload Document</label>
            <input type="file" name="document" class="form-control">
            <div id="currentDoc" class="mt-1"></div>
          </div>

          <!-- brochure Upload -->
          <div class="mb-3">
            <label class="form-label">Upload image</label>
            <input type="file" name="image" class="form-control">
            <img id="currentImg" src="" class="mt-2 rounded" style="max-height:60px; display:none;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this item?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openCreateModal() {
    const modal = document.getElementById('mediaModal');
    document.getElementById('modalTitleText').innerText = 'Add New Brochure';
    document.getElementById('mediaForm').action = "{{ route('e_admin.marketing.store') }}";
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('mediaTitle').value = '';
    document.getElementById('mediaDescription').value = '';
    document.getElementById('mediaContentType').value = 'brochure';
    document.getElementById('currentImg').style.display = 'none';
    document.getElementById('currentDoc').innerHTML = '';
    new bootstrap.Modal(modal).show();
}

function openEditbrochureModal(id, title, description, contentType, brochureUrl, docUrl) {
    const modal = document.getElementById('mediaModal');
    document.getElementById('modalTitleText').innerText = 'Edit Brochure';
    document.getElementById('mediaForm').action = `/emetrotel-admin/marketing/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('mediaTitle').value = title;
    document.getElementById('mediaDescription').value = description;
    document.getElementById('mediaContentType').value = contentType;

    const img = document.getElementById('currentImg');
    img.style.display = brochureUrl ? 'block' : 'none';
    img.src = brochureUrl || '';

    const doc = document.getElementById('currentDoc');
    doc.innerHTML = docUrl ? `<a href="${docUrl}" target="_blank">Preview Document</a>` : '';

    new bootstrap.Modal(modal).show();
}

function openDeleteModal(id) {
    document.getElementById('deleteForm').action = `/emetrotel-admin/marketing/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
