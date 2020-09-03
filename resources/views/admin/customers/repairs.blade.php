<div class="card">
    {{-- <p>{{ $customer->enquiries->first()->quotations }}</p> --}}
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Has Spare Part Replacement</th>
                    <th>Team Type</th>
                    <th>Service Report PDF</th>
                    <th>Created By</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
                @if (! $customer->enquiries->isEmpty())
                    @foreach ($customer->enquiries as $enquiry)   
                        @if ($enquiry->quotations->first())
                            @if ($enquiry->quotations->first()->saleContract)                                    
                                @if ($enquiry->quotations->first()->saleContract->on_calls)                                            
                                    @foreach ($enquiry->quotations->first()->saleContract->on_calls as $on_call)
                                        @if ($on_call->repairs)                                                
                                            @foreach ($on_call->repairs as $repair)
                                            <tr>
                                                <td>
                                                    {{ $repair->created_at->format('M-d-Y') ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $repair->has_spare_part_replacement ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $repair->team_type ?? '' }}
                                                </td>
                                                <td>
                                                    @if($repair->service_report_pdf)
                                                        <a href="{{ $repair->service_report_pdf }}" target="_blank">
                                                            {{ trans('global.view_file') }} <i class="fas fa-arrow-circle-right"></i>
                                                        </a>
                                                    @endif
                                                </td>                                                
                                                <td>
                                                    {{ $repair->created_by->name ?? '' }}
                                                </td>
                                                <td>                                                
                                                    <a href="{{ route('admin.repairs.show', $repair) }}"
                                                    class="btn btn-sm btn-primary rounded-pill">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>

                                            @endforeach        
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @else                            
                            @if ($enquiry->saleContract)                                    
                                @if ($enquiry->saleContract->on_calls)                                            
                                    @foreach ($enquiry->saleContract->on_calls as $on_call)
                                        @if ($on_call->repairs)                                                
                                            @foreach ($on_call->repairs as $repair)
                                            <tr>
                                                <td>
                                                    {{ $repair->created_at->format('M-d-Y') ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $repair->has_spare_part_replacement ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $repair->team_type ?? '' }}
                                                </td>
                                                <td>
                                                    @if($repair->service_report_pdf)
                                                        <a href="{{ $repair->service_report_pdf }}" target="_blank">
                                                            {{ trans('global.view_file') }} <i class="fas fa-arrow-circle-right"></i>
                                                        </a>
                                                    @endif
                                                </td>                                                
                                                <td>
                                                    {{ $repair->created_by->name ?? '' }}
                                                </td>
                                                <td>                                                
                                                    <a href="{{ route('admin.repairs.show', $repair) }}"
                                                    class="btn btn-sm btn-primary rounded-pill">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>

                                            @endforeach        
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endif
                    @endforeach
                @endif
            <tbody>
                
            </tbody>
        </table>

    </div>
</div>