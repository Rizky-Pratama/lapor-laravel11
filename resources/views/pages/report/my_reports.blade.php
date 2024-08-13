@extends('layouts.adminLayout.index')

@section('styles')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('title_content', 'Data Reports')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('reports.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Report</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" style="min-width: max-content">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Floor Number</th>
                        <th style="max-width: 400px">Message</th>
                        <th>Date</th>
                        <th class="notext">action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Floor Number</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($reports as $report)
                        @php
                            $date = \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i:s');
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $report->floor->floor_number }}</td>
                            <td>{{ $report->message }}</td>
                            <td>{{ $date }}</td>
                            <td>
                                <a href="{{ route('reports.show', $report->id) }}"
                                   class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>
@endsection
