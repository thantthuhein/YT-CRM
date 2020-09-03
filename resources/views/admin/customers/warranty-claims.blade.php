<div class="card">
    <div class="card-body">
        {{-- <h1>{{ $customer->enquiries->first()->saleContract->on_calls->first()->warrantyClaims }}</h1> --}}
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Actual Date</th>
                    <th>Daikin rep name</th>
                    <th>PDF</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @if (! $customer->enquiries->isEmpty())
                    @foreach ($customer->enquiries as $enquiry)                        
                        @if ($enquiry->quotations->first())
                            @if ($enquiry->quotations->first()->saleContract)      
                                @if ($enquiry->quotations->first()->saleContract->on_calls)                                            
                                    @foreach ($enquiry->quotations->first()->saleContract->on_calls as $on_call)
                                        @if ($on_call->warrantyClaims)                                                
                                            @foreach ($on_call->warrantyClaims as $warrantyClaim)
                                            <tr>
                                                <td>
                                                    {{ $warrantyClaim->created_at->format('M-d-Y') ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $warrantyClaim->warranty_claim_validation->actual_date ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $warrantyClaim->warranty_claim_action->daikin_rep_name ?? '' }}
                                                </td>
                                                <td>
                                                    @if($warrantyClaim->warranty_claim_pdf)
                                                        <a href="{{ $warrantyClaim->warranty_claim_pdf }}" target="_blank">
                                                            {{ trans('global.view_file') }} <i class="fas fa-arrow-circle-right"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="{{ $warrantyClaim->status }}">
                                                    {{ App\WarrantyClaim::STATUS_SELECT[$warrantyClaim->status] ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $warrantyClaim->created_by->name ?? '' }}
                                                </td>
                                                <td>                                                
                                                    <a href="{{ route('admin.warranty-claims.show', $warrantyClaim) }}"
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
                                        @if ($on_call->warrantyClaims)                                                
                                            @foreach ($on_call->warrantyClaims as $warrantyClaim)
                                            <tr>
                                                <td>
                                                    {{ $warrantyClaim->created_at->format('M-d-Y') ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $warrantyClaim->warranty_claim_validation->actual_date ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $warrantyClaim->warranty_claim_action->daikin_rep_name ?? '' }}
                                                </td>
                                                <td>
                                                    @if($warrantyClaim->warranty_claim_pdf)
                                                        <a href="{{ $warrantyClaim->warranty_claim_pdf }}" target="_blank">
                                                            {{ trans('global.view_file') }} <i class="fas fa-arrow-circle-right"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="{{ $warrantyClaim->status }}">
                                                    {{ App\WarrantyClaim::STATUS_SELECT[$warrantyClaim->status] ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $warrantyClaim->created_by->name ?? '' }}
                                                </td>
                                                <td>                                                
                                                    <a href="{{ route('admin.warranty-claims.show', $warrantyClaim) }}"
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
            </tbody>

        </table>
    </div>

</div>