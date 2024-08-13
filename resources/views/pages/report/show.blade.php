@extends('layouts.adminLayout.index')

@section('title_content', 'Detail Report')

@section('styles')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
@endsection

@section('content')
    @use('Carbon\Carbon')
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    Report Summary
                </div>
                <div class="card-body">
                    <p><strong>Floor:</strong> {{ $report->floor->floor_number }}</p>
                    <p><strong>Author:</strong> {{ $report->user->name }}</p>
                    <p>
                        <strong>Date:</strong> {{ Carbon::parse($report->created_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    Detailed Message
                </div>
                <div class="card-body">
                    <p>{{ $report->message }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Photos
                </div>
                <div class="card-body">
                    <div id="gallery" class="d-flex flex-wrap">
                        @foreach($report->photos as $photo)
                            <a data-fancybox data-src={{ asset('storage/' . $photo->photo_path) }}>
                                <img class="img-thumbnail " src="{{ asset('storage/' . $photo->photo_path) }}"
                                     alt="{{ $photo->photo_path }}"
                                     style="max-width: 350px">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-warning">
                <i class="fas fa-chevron-left"></i>
                Back
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('#gallery a', {
            groupAll: true,
        });
    </script>
@endsection
