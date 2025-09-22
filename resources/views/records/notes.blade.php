@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('records.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                        </a>
                        Record
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @include('records.partials.top_cards')
            <div class="card">
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('records.partials.tabs')
                            <div class="row">

                                <div class="col-12">

                                    <div class="row align-items-center mb-3">
                                        <div class="col">
                                            <h2 class="text-lime">Notes</h2>
                                        </div>
                                        <div class="col-auto ms-auto d-print-none">
                                            <div class="btn-list">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary">Add Notes</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Body</th>
                                                <th class="w-1">Actions</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($notes as $note)
                                                <tr>
                                                    <td><span class="text-wrap">{{timeToDate($note->date)}}</span></td>
                                                    <td><span class="text-wrap">{{$note->subject}}</span></td>
                                                    <td><span class="text-wrap">{{$note->body}}</span></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm delete-note-btn" data-note-id="{{ $note->id }}">Delete</button></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="20">
                                                        <div class="empty">
                                                            <div class="empty-img"><img src="{{ asset('') }}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt=""></div>
                                                            <p class="empty-title">No Notes</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row align-items-center mt-3">
                                        <div class="col">
                                            <h2 class="text-lime mt-3">Retired Hosts</h2>
                                        </div>
                                        <div class="col-auto ms-auto d-print-none">
                                            <div class="btn-list">
                                                <button type="button" id="edit-btn" class="btn btn-primary">Edit</button>
                                                <button type="button" id="discard-btn" class="btn btn-secondary d-none" >Discard Changes</button>
                                                <button type="submit" id="save-btn" class="btn btn-primary d-none" form="retired-hosts-form">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <form id="retired-hosts-form" action="{{ route('records.save_retired_hosts', $record->slno) }}" method="POST">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>Host ID</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="retired-hosts-body">
                                                    @if(!isEmptyHostFields($record))
                                                        @if(!empty($record->retired_host_id1) || !empty($record->retired_host_note1))
                                                            <tr>
                                                                <td><span class="text-wrap">{{ $record->retired_host_id1 }}</span></td>
                                                                <td><span class="text-wrap">{{ $record->retired_host_note1 }}</span></td>
                                                            </tr>
                                                        @endif
                                                        @if(!empty($record->retired_host_id2) || !empty($record->retired_host_note2))
                                                            <tr>
                                                                <td><span class="text-wrap">{{ $record->retired_host_id2 }}</span></td>
                                                                <td><span class="text-wrap">{{ $record->retired_host_note2 }}</span></td>
                                                            </tr>
                                                        @endif
                                                        @if(!empty($record->retired_host_id3) || !empty($record->retired_host_note3))
                                                            <tr>
                                                                <td><span class="text-wrap">{{ $record->retired_host_id3 }}</span></td>
                                                                <td><span class="text-wrap">{{ $record->retired_host_note3 }}</span></td>
                                                            </tr>
                                                        @endif
                                                        @if(!empty($record->retired_host_id4) || !empty($record->retired_host_note4))
                                                            <tr>
                                                                <td><span class="text-wrap">{{ $record->retired_host_id4 }}</span></td>
                                                                <td><span class="text-wrap">{{ $record->retired_host_note4 }}</span></td>
                                                            </tr>
                                                        @endif
                                                    @else
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="empty">
                                                                    <div class="empty-img"><img src="{{ asset('') }}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt=""></div>
                                                                    <p class="empty-title">No Host IDs</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- Input fields will be dynamically added here in edit mode -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="add-note-form" action="{{ route('records.save_note', $record->slno) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject" class="form-control" required maxlength="255">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Body</label>
                                        <textarea name="body" class="form-control" rows="5" required></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Hidden Delete Note Form -->
        <form id="delete-note-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let isEditing = false;
            const editBtn = document.getElementById('edit-btn');
            const saveBtn = document.getElementById('save-btn');
            const form = document.getElementById('retired-hosts-form');
            const retiredHostsBody = document.getElementById('retired-hosts-body');
            const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
            const discardBtn = document.getElementById('discard-btn');
            const deleteNoteButtons = document.querySelectorAll('.delete-note-btn');
            const deleteNoteForm = document.getElementById('delete-note-form');

            // Store original table content to restore on save or discard
            const originalContent = retiredHostsBody.innerHTML;

            // Input fields HTML for all four retired host pairs
            const inputFields = `
            <tr>
                <td><input type="text" name="retired_host_id1" value="{{ $record->retired_host_id1 ?? '' }}" class="form-control"></td>
                <td><input type="text" name="retired_host_note1" value="{{ $record->retired_host_note1 ?? '' }}" class="form-control"></td>
            </tr>
            <tr>
                <td><input type="text" name="retired_host_id2" value="{{ $record->retired_host_id2 ?? '' }}" class="form-control"></td>
                <td><input type="text" name="retired_host_note2" value="{{ $record->retired_host_note2 ?? '' }}" class="form-control"></td>
            </tr>
            <tr>
                <td><input type="text" name="retired_host_id3" value="{{ $record->retired_host_id3 ?? '' }}" class="form-control"></td>
                <td><input type="text" name="retired_host_note3" value="{{ $record->retired_host_note3 ?? '' }}" class="form-control"></td>
            </tr>
            <tr>
                <td><input type="text" name="retired_host_id4" value="{{ $record->retired_host_id4 ?? '' }}" class="form-control"></td>
                <td><input type="text" name="retired_host_note4" value="{{ $record->retired_host_note4 ?? '' }}" class="form-control"></td>
            </tr>
        `;

            function updateInputs() {
                return form.querySelectorAll('input, select, textarea, input[type="radio"], input[type="checkbox"]');
            }

            editBtn.addEventListener('click', function () {
                isEditing = true;
                // Replace table content with input fields
                retiredHostsBody.innerHTML = inputFields;
                const inputs = updateInputs();
                inputs.forEach(input => {
                    input.disabled = false;
                });
                editBtn.classList.add('d-none');
                saveBtn.classList.remove('d-none');
                discardBtn.classList.remove('d-none');

            });

            saveBtn.addEventListener('click', function () {
                isEditing = false;
                // Form submission handled by the browser
                const inputs = updateInputs();

                editBtn.classList.remove('d-none');
                saveBtn.classList.add('d-none');
                discardBtn.classList.add('d-none');

            });
            discardBtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'Discard Changes?',
                    text: 'You have unsaved changes. Are you sure you want to discard them?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, discard',
                    cancelButtonText: 'No, stay',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            });

            tabLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    if (isEditing) {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Discard Changes?',
                            text: 'You have unsaved changes. Are you sure you want to discard them?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, discard',
                            cancelButtonText: 'No, stay',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                isEditing = false;
                                // Restore original table content
                                retiredHostsBody.innerHTML = originalContent;
                                editBtn.classList.remove('d-none');
                                saveBtn.classList.add('d-none');
                                window.location.href = link.href;
                            }
                        });
                    }
                });
            });


            // Handle delete note buttons
            deleteNoteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const noteId = this.getAttribute('data-note-id');
                    Swal.fire({
                        title: 'Delete Note?',
                        text: 'Are you sure you want to delete this note? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'No, cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Set the form action and submit
                            deleteNoteForm.action = '{{ route("records.delete_note", ["slno" => $record->slno, "note" => ":note"]) }}'.replace(':note', noteId);
                            deleteNoteForm.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
