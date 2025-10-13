<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dect;
use App\Models\DectExtension;
use Illuminate\Support\Facades\DB;

class DectExtensionController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:4096',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);

        // Normalize CSV headers
        $header = array_map(fn($h) => trim(preg_replace('/\xEF\xBB\xBF/', '', $h)), $header);

        $imported = 0;
        $skipped = 0;
        $macIndexes = [];
        $macCounts = []; // track number of new extensions per MAC

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);
                if (!$data) continue;

                // Only import SIP rows
                if (!isset($data['Tech']) || strtolower(trim($data['Tech'])) !== 'sip') {
                    $skipped++;
                    continue;
                }

                $mac = trim($data['MAC Address'] ?? '');
                if (empty($mac)) {
                    $skipped++;
                    continue;
                }

                $extension = trim($data['User Extension'] ?? '');
                if (empty($extension)) {
                    $skipped++;
                    continue;
                }

                // Find all DECTs with same MAC
                $matchingDects = Dect::where('mac', $mac)->get();
                if ($matchingDects->isEmpty()) {
                    $skipped++;
                    continue;
                }

                // Initialize per-MAC index
                if (!isset($macIndexes[$mac])) {
                    $lastIndex = DectExtension::where('mac', $mac)->max('index');
                    $macIndexes[$mac] = is_numeric($lastIndex) ? $lastIndex + 1 : 0;
                }

                // Skip duplicates
                $exists = DectExtension::where('mac', $mac)
                    ->where('extension', $extension)
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                // Create new DectExtension record
                DectExtension::create([
                    'mac'           => $mac,
                    'display_name'  => $data['Display Name'] ?? null,
                    'secret'        => $data['Secret'] ?? null,
                    'extension'     => $extension,
                    'index'         => $macIndexes[$mac],
                ]);

                $macIndexes[$mac]++;
                $imported++;
                $macCounts[$mac] = ($macCounts[$mac] ?? 0) + 1;
            }

            // ✅ Update DECT table "extension" field with total count of extensions
            foreach ($macCounts as $mac => $count) {
                $total = DectExtension::where('mac', $mac)->count();

                Dect::where('mac', $mac)->update([
                    'extension' => $total,
                ]);
            }

            DB::commit();
            fclose($handle);

            return back()->with('success', "Imported {$imported} SIP extensions. Skipped {$skipped} duplicates or invalid rows.");
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
