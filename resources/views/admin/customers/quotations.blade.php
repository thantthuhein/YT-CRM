<div class="card">
    <div class="card-body">
        {{-- <p>{{ $customer->quotations }}</p> --}}
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Quotation Number</th>
                    <th>Status</th>
                    <th>Last Revised PDF</th>
                    <th>Last Quoted Date</th>
                    <th>Last Follow Up Date</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @if ( ! $customer->quotations->isEmpty())                    
                    @foreach ($customer->quotations as $quotation)
                        <tr>
                            <td>{{ $quotation->created_at->format('d-D-M-Y') }}</td>
                            <td>{{ $quotation->number ?? '' }}</td>
                            <td>{{ $quotation->status ?? '' }}</td>
                            <td>
                                @if ($quotation->quotationRevisions->last())
                                    <a href="{{ $quotation->quotationRevisions->last()->quotation_pdf }}" 
                                    class="btn btn-sm btn-primary rounded-pill" target="_blank">View PDF</a>
                                @endif
                            </td>
                            <td>
                                @if ($quotation->quotationRevisions->last())
                                    {{$quotation->quotationRevisions->last()->quoted_date}}
                                @else 
                                    No Revised Quotations
                                @endif
                            </td>
                            <td>
                                @if ($quotation->quotationRevisions->last())
                                    @if ($quotation->quotationRevisions->last()->followUps->last())
                                        {{ $quotation->quotationRevisions->last()->followUps->last()->follow_up_time }}
                                    @else
                                        No Follow Up
                                    @endif           
                                @else
                                    No Revised Quotations                         
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.quotations.show', $quotation) }}" 
                                class="btn btn-sm btn-primary rounded-pill">View</a>
                            </td>
                        </tr>                        
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>