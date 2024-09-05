<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Report;
use App\Models\ReportPhoto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::with(['user', 'floor'])->get();
        return view('pages.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $floors = Floor::all();
        return view('pages.report.create', compact('floors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->id();
        $qr_code = $request->qrcode;
        $floor = Floor::where('qrcode', $qr_code)->first();

        if (!$floor) {
            $request->session()->flash('error', 'Invalid QR code');
            return redirect()->route('reports.create');
        }

        // Validate the request
        $request->validate([
            'message' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $location = $request->latitude . ',' . $request->longitude;
        $data = [
            'user_id' => $user_id,
            'floor_id' => $floor->id,
            'message' => $request->message,
            'location' => $location,
        ];

        // Create a new report
        $report = Report::create($data);

        // Store the photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPath = $photo->store('photos', 'public');
                ReportPhoto::create([
                    'report_id' => $report->id,
                    'photo_path' => $photoPath,
                ]);
            }
        }
        $request->session()->flash('success', 'Report created successfully');
        return redirect()->route('reports.my-reports');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        Gate::authorize('edit-report', $report);
        $report = $report->load(['floor', 'photos', 'user']);
        return view('pages.report.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        Gate::authorize('edit-report', $report);
        $report = $report->load(['photos']);
        return view('pages.report.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        Gate::authorize('edit-report', $report);

        $request->validate([
            'message' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $oldPhotos = $report->photos;
        $newPhotos = $request->file('photos');

        $report->update([
            'message' => $request->message,
        ]);

        if ($newPhotos) {
            foreach ($oldPhotos as $photo) {
                Storage::delete('public/' . $photo->photo_path);
                $photo->delete();
            }
            foreach ($newPhotos as $photo) {
                $photoPath = $photo->store('photos', 'public');
                ReportPhoto::create([
                    'report_id' => $report->id,
                    'photo_path' => $photoPath,
                ]);
            }
        }

        session()->flash('success', 'Report updated successfully');
        return redirect()->route('reports.my-reports');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        session()->flash('success', 'Report deleted successfully');
        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     */
    public function myReports()
    {
        $reports = Report::where('user_id', auth()->id())->with(['floor'])->get();
        return view('pages.report.my_reports', compact('reports'));
    }

    public function exportAllReports()
    {
        $reports = Report::with(['user', 'floor'])->get();
        $pdf = Pdf::loadView('pdf.reports', compact('reports'));
        return $pdf->stream('reports.pdf');
//        return view('pdf.reports', compact('reports'));
    }
}
