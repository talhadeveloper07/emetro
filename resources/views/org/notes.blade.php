@extends('layouts.admin')

@section('content')
    @include('org.header')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('org.header_tabs')
                            <div class="tab-content">
                                <div class="tab-pane active show" role="tabpanel">
                                    <div class="row">
                                        @if(count($org->notes))
                                            <div class="col-12 mb-3">
                                                <div class="table-responsive">
                                                    <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                                        <thead>
                                                        <tr>
                                                            <th>Author</th>
                                                            <th>Note</th>
                                                            <th class="w-1"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($org->notes as $note)
                                                            <tr>
                                                                <td>{{ $note->created_at }}</td>
                                                                <td><span class="text-wrap">{{ $note->note }}</span></td>
                                                                <td>
                                                                    @if($note->note_type == "private")
                                                                        <span class="badge">Internal</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                        <form action="{{ route('org.notes.save', $org->id) }}" id="noteForm" method="POST" class="w-100">
                                            @csrf
                                            <input type="hidden" name="note_type" id="note_type" value="">
                                            <div class="col-md-12 col-sm-12 mb-3">
                                                <label class="form-label required">Note</label>
                                                <textarea name="note" class="form-control" id="" cols="30" rows="10" required></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12 text-end">
                                                <button type="button" class="btn btn-primary btn-share">Share with customer</button>
                                                <button type="button" class="btn btn-secondary btn-internal">Comment internally</button>
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
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            function submitNoteForm(noteType) {
                const form = document.getElementById('noteForm');

                // Set note_type value
                $('#note_type').val(noteType);

                // Use native browser validation
                if (form.checkValidity()) {
                    form.submit();
                } else {
                    form.reportValidity(); // triggers native validation message
                }
            }

            $('.btn-internal').click(function () {
                submitNoteForm('private');
            });

            $('.btn-share').click(function () {
                submitNoteForm('public');
            });
        });
    </script>
@endsection
