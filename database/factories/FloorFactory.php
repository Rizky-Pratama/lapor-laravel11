<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FloorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $floorNumber = 1;

        $writer = new PngWriter();
        // Generate the barcode data
        $barcodeData = Str::random(20);

        // Create a QR code
        $qrCode = QrCode::create($barcodeData);
        $qrCode->setSize(300);
        $result = $writer->write($qrCode);

        // Save QR code to storage
        $qrCodePath = 'qrcodes/floor-' . $floorNumber . '.png';
        Storage::disk('public')->put($qrCodePath, $result->getString());

        return [
            'floor_number' => $floorNumber++,
            'qrcode' => $barcodeData,
        ];
    }
}
