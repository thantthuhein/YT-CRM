@if ($remainingJobs->isEmpty())
    <h5 class="text-center text-white">No Remaining Jobs For Today</h5>
@else    
    <div class="table-responsive scrollbar">
        <table class="en-list table table-borderless table-striped scrollbar">
            <tbody>
                @foreach($remainingJobs as $key => $remainingJob)
                    <tr>
                        <td>
                            {{ $remainingJob->reminder_description }} 

                            @switch($remainingJob->reminderType->type)
                                @case('followup')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, ['quotation_id' => $remainingJob->quotation_morph->morph_id, 'quotation_revision_id' => $remainingJob->quotation_revision_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('sale_contract_estimated_date')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, ['sale-contract-id' => $remainingJob->sale_contract_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('uploaded_by_sale_engineer')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->sale_contract_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('installation_weekly_update')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->in_house_installation_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('installation_necessary_docs')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->in_house_installation_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('actual_installation_report_pdf')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->in_house_installation_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('maintenance')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('contract_maintenance')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('maintenance_estimated_date')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('service_report')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->servicing_setup_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('warranty_claim_form')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->warranty_claim_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('warranty_estimated_date')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->warranty_claim_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('warranty_claim_approve')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->warranty_claim_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('warranty_action_pdfs')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->warranty_claim_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('repair_estimated_date')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->repair_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @case('repair_service_report')
                                    <a class="d-block text-light" href="{{ route($remainingJob->reminderType->action, [$remainingJob->repair_morph->morph_id]) }}"><i class="far fa-calendar-check mr-2"></i>View Details</a>
                                    @break
                                @default
                                No action assign
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif