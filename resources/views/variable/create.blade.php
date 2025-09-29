@extends('layouts.admin')

@section('content')

    <div class="page-body">
        <div class="container-xl">
            <div class="card p-4">

                <div id="updateCardContent">

                    <form action="{{ route('variables.store') }}" method="POST">
                        @csrf
                        <label>Variable Name:</label>
                        <input type="text" name="name" required>

                        <label>Value (comma separated):</label>
                        <input type="text" name="value" required>

                        <button type="submit">Save</button>
                    </form>


                </div>

            </div>
        </div>
    </div>

@endsection