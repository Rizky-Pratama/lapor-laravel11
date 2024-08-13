<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $floors = Floor::all();
        return view('pages.floor.index', ['floors' => $floors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'floor_number' => 'required|numeric|unique:floors',
        ]);

        $writer = new PngWriter();
        $floorNumber = $request->floor_number;
        $barcodeData = Str::random(20);

        $qrCode = QrCode::create($barcodeData);
        $qrCode->setSize(300);
        $result = $writer->write($qrCode);

        $qrCodePath = 'qrcodes/floor-' . $floorNumber . '.png';
        Storage::disk('public')->put($qrCodePath, $result->getString());

        Floor::create([
            'floor_number' => $floorNumber,
            'qrcode' => $barcodeData,
        ]);

        $request->session()->flash('success', 'Floor created successfully');
        return redirect()->route('floors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Floor $floor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Floor $floor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Floor $floor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Floor $floor)
    {
        $qrCodePath = $floor->qrcode;
        $floor->delete();

        if (Storage::disk('public')->exists($qrCodePath)) {
            Storage::disk('public')->delete($qrCodePath);
        }

        $request->session()->flash('success', 'Floor deleted successfully');
        return redirect()->route('floors.index');

    }
}
