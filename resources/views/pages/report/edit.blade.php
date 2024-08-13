@extends('layouts.adminLayout.index')

@section('title_content', 'Edit Report')

@section('styles')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
@endsection
@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    {{--    {{dd($report)}}--}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Report</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="qrcode">Qr Code</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="number" id="number"
                               value="{{ $report->floor->floor_number }}" readonly disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="qrcode">Images</label>
                    <div id="gallery" class="d-flex flex-wrap">
                        @foreach($report->photos as $photo)
                            <a data-fancybox data-src={{ asset('storage/' . $photo->photo_path) }}>
                                <img class="img-thumbnail " src="{{ asset('storage/' . $photo->photo_path) }}"
                                     alt="{{ $photo->photo_path }}"
                                     style="max-width: 100px">
                            </a>
                        @endforeach
                    </div>
                    <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input @error('photos.*') is-invalid @enderror" id="photos"
                               name="photos[]"
                               aria-describedby="inputGroupFileAddon01" multiple>
                        <label class="custom-file-label" for="photos">Choose file</label>
                        @error('photos.*')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" name="message" id="message" rows="10" style="resize: none">
                        {{ old('message') ?? $report->message }}
                    </textarea>
                    @error('message')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        bsCustomFileInput.init()
        Fancybox.bind('#gallery a', {
            groupAll: true,
        });
        {{--        pada saat document susah diload, value dari texarea ditrim  dengan jquery--}}
        document.addEventListener('DOMContentLoaded', function () {
            $('#message').val($('#message').val().trim());
        });

    </script>
@endsection
