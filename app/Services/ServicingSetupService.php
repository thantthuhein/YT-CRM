<?php
namespace App\Services;

use App\ServicingSetup;
use App\Traits\ImageUploadTrait;

class ServicingSetupService {
    
    use ImageUploadTrait;

    public function create($request)
    {
        $title = "Project_" . $request['project_id'] . "_is_major_" . $request['is_major'];
        $folder = config('bucket.maintenance_file_path');
        $service_report_pdf = static::storeFileToBucket($title, $request['service_report_pdf'], $folder);
        
        $servicingSetup = ServicingSetup::create([
            "project_id" => $request['project_id'],
            "is_major" => $request['is_major'],
            "estimated_date" => $request['estimated_date'],
            "actual_date" => $request['actual_date'],
            "request_type" => $request['request_type'],
            "team_type" => $request['team_type'],
            "service_report_pdf" => $service_report_pdf,
        ]);

        return $servicingSetup;
        
    }

    public function update()
    {
        
    }
    
}
