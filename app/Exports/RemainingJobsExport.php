<?php

namespace App\Exports;

use App\ReminderType;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RemainingJobsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    private $remainingJobs;

    public $link;

    
    public function __construct($remainingJobs)
    {
        $this->remainingJobs = $remainingJobs;        
    }
    
    public function headings():array{
        return [
            '#',
            'Description',
            'Link'
        ];
    }
    
    
    public function map($remainingJob):array{
        switch($remainingJob->reminderType->type) {
            case 'followup':
                $this->link = route($remainingJob->reminderType->action, ['quotation_id' => $remainingJob->quotation_morph->morph_id, 'quotation_revision_id' => $remainingJob->quotation_revision_morph->morph_id]);
            break;
            case 'sale_contract_estimated_date':
                $this->link = route($remainingJob->reminderType->action, ['sale-contract-id' => $remainingJob->sale_contract_morph->morph_id]);
            break;
            case 'uploaded_by_sale_engineer':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->sale_contract_morph->morph_id]);
            break;
            case 'installation_weekly_update':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->in_house_installation_morph->morph_id]);
            break;
            case 'installation_necessary_docs':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->in_house_installation_morph->morph_id]);
            break;
            case 'actual_installation_report_pdf':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->in_house_installation_morph->morph_id]);
            break;
            case'maintenance':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]);
            break;
            case'contract_maintenance':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]);
            break;
            case'maintenance_estimated_date':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]);
            break;
            case'service_report':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]);
            break;
            case'warranty_claim_form':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->warranty_claim_morph->morph_id]);
            break;
            case'warranty_estimated_date':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->warranty_claim_morph->morph_id]);
            break;
            case'warranty_action_pdfs':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->warranty_claim_morph->morph_id]);
            break;
            case'repair_estimated_date':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->repair_morph->morph_id]);
            break;
            case'repair_service_report':
                $this->link = route($remainingJob->reminderType->action, [$remainingJob->repair_morph->morph_id]);
            break;
            default:
            return 'No action assign';
        }
        return [
            $remainingJob->id,
            $remainingJob->reminderType->description,
            $this->link,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->remainingJobs;
    }
}
