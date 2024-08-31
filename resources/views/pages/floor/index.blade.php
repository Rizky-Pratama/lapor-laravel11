@extends('layouts.adminLayout.index')

@section('styles')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('title_content', 'Data Floors')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <button class="btn btn-success btn-icon-split" data-toggle="modal"
                    data-target="#addFloor">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Floor</span>
            </button>
            <div class="d-flex">
                <a href="{{ route('floors.download-all-qrcodes') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Download Qr Codes</span>
                </a>
                {{--                <a href="{{ route('floors.print', ['type' => 'pdf']) }}" class="btn btn-danger btn-icon-split">--}}
                {{--                    <span class="icon text-white-50">--}}
                {{--                        <i class="fas fa-file-pdf"></i>--}}
                {{--                    </span>--}}
                {{--                    <span class="text">Export PDF</span>--}}
                {{--                </a>--}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th>Floor Number</th>
                        <th class="notext">Barcode</th>
                        <th class="notext">action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Floor Number</th>
                        <th>Barcode</th>
                        <th>action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($floors as $floor)
                        <tr>
                            <td>{{ $floor->floor_number }}</td>
                            <td>
                                <img src="{{ asset('storage/qrcodes/floor-' . $floor->floor_number.'.png') }}"
                                     alt="{{ $floor->floor_number }}"
                                     width="100">
                            </td>
                            <td>
                                <form action="{{ route('floors.destroy', $floor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ asset('storage/qrcodes/floor-' . $floor->floor_number . '.png') }}"
                                   download="floor-{{ $floor->floor_number }}.png" class="btn btn-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addFloor" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Floor</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('floors.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group" id="floor_number">
                            <label for="floor_number">Floor Number</label>
                            <input type="number" class="form-control @error('floor_number') is-invalid @enderror"
                                   name="floor_number" id="floor_number" value="{{ old('floor_number') }}">
                            @error('floor_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function () {
            @if ($errors->any())
            $('#addFloor').modal('show');
            @endif
        });
    </script>
@endsection
