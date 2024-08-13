@extends('layouts.adminLayout.index')

@section('title_content', 'Add User')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form add Report</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="qrcode">Qr Code</label>
                    <div id="reader" class="mb-3" style="max-width: 500px; display: none"></div>
                    <div class="input-group">
                        <input type="text" class="form-control" name="qrcode" id="qrcode" value="{{ old('qrcode') }}"
                               readonly>
                        <div class="input-group-append">
                            <button class="btn btn-warning" type="button" id="stop">Stop</button>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="scanQrCode">Scan</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" name="message" id="message" cols="30" rows="10">
                        {{ old('message') }}
                    </textarea>
                    @error('message')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Photos</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="photos" name="photos[]"
                               aria-describedby="inputGroupFileAddon01" multiple>
                        <label class="custom-file-label" for="photos">Choose file</label>
                    </div>
                    @error('photos')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            Add
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('message').value = '';
        });
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            {fps: 10, qrbox: {width: 250, height: 250}}, true);

        let reader = document.getElementById('reader');

        function onScanSuccess(decodedText, decodedResult) {
            // Stop the scanner to avoid scanning again
            const qrCode = document.getElementById('qrcode');
            qrCode.value = decodedText;

            reader.style.display = 'none';
            html5QrcodeScanner.clear();
        }

        document.getElementById('stop').addEventListener('click', function () {
            reader.style.display = 'none';
            html5QrcodeScanner.clear();
        });
        document.getElementById('scanQrCode').addEventListener('click', function () {
            reader.style.display = 'block';
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
@endsection
