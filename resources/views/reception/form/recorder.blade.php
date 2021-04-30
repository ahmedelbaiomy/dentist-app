@extends('layouts/layoutMaster')

@section('title', 'Appointments Lists')

@section('vendor-style')

@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recorder</h4>
                <!-- recoder -->
                <div id="controls">
                    <button id="recordButton">Record</button>
                    <button id="pauseButton" disabled>Pause</button>
                    <button id="stopButton" disabled>Stop</button>
                </div>
                <div id="formats">Format: start recording to see sample rate</div>
                <p><strong>Recordings:</strong></p>
                <ol id="recordingsList"></ol>
                <!-- recoder -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/js/recorder.js') }}"></script>
<!-- <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script> -->
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/recorder-script.js') }}"></script>
<script src="{{ asset('new-assets/js/main.js') }}"></script>
@endsection