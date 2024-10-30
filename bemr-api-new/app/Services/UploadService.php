<?php

namespace App\Services;


use Illuminate\Support\Facades\Log;

class UploadService
{


    public function parseCsv($filepath)
    {
        $file = storage_path('app/public/'. $filepath);
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $csv = [];
        foreach ($rows as $row) {
            $csv['ids'] = array_slice($row, 3,1);
        }
        $csv = array_slice($csv, 1);
        if (count($csv)) {
            dd($csv);
            exit;
           foreach ($csv as $item) {
               $affiseData = [
                   'ids' => $item,
                   'status' => 'declined'
               ];
               $this->sendDataToAffise($affiseData);
           }
        }else{
            return response()->json(['status' => 400, 'statusText' => 'wrongData']);
        }
        return response()->json(['status' => 200, 'statusText' => 'OK']);
    }

    private function sendDataToAffise($data): void
    {
        $options = [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(config('app.affise_api_key')),
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HEADER => false,
        ];
        $url = config('app.affise_url') . '/3.0/admin/conversion/edit';
        $html = json_decode($this->curl($url, $options), true);

        Log::channel('affiseChangeStatus')->info($html);
    }

}
