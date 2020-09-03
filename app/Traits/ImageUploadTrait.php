<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait {
    public function storeFileToBucket($title = "DEFAULT", $file, $folder = 'images'){

        // putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/tth/Desktop/YT/ywar-taw-030d5350ef6a.json');

        $fileName = $title . "_" . $this->currentDateTime() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
        
        $absolutePath = $folder . '/' . $fileName;

        $fileContent = file_get_contents($file);

        $disk = Storage::disk('gcs');

        $disk->put($absolutePath, $fileContent);

        $completeUrl = $disk->url($absolutePath);

        return $completeUrl;
    }

    public function currentDateTime(){
        return now()->format('Y-m-d-H-m-s');
    }
}