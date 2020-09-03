<table class="en-list table table-borderless table-striped scrollbar">
    <thead>
        <tr>
            <th width='10'>#</th>
            <th>Project</th>
            <th>Customer</th>
            <th>Company</th>
            <th>Location</th>
            <th>Air-con Types</th>
            <th>Quotation Number</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Last Quotated Date</th>
            <th>Last Revision PDF</th>
            <th>Last Follow Up Date</th>
            <th>Contact Person</th>
            <th>Last Follow Up Remark</th>
        </tr>
    </thead>
    <tbody>
        @php
            $order = order(request()->page ?? 1, $quotations->perPage())
        @endphp
       @foreach($quotations as $quotation)
            <tr>
                <td>{{ $order++ }}</td>
                <td> {{ $quotation->enquiries->first()->project->name ?? "N/A" }}</td>
                <td>{{ $quotation->customer->name}}</td>
                <td>{{ $quotation->enquiries->first()->company->name ?? "N/A"}}</td>
                <td>{{ $quotation->enquiries->first()->location}}</td>
                <td>{{ implode(', ', $quotation->enquiries->first()->airconTypes->pluck('type')->toArray())}}</td>
                <td>{{ $quotation->number}}</td>
                <td>{{ $quotation->status}}</td>
                <td>{{ $quotation->created_by->name}}</td>
                <td>{{ $quotation->quotationRevisions->last() ? $quotation->quotationRevisions->last()->quoted_date : ''}}</td>
                <td>
                    @if ($quotation->quotationRevisions->last())                        
                        @if($quotation->quotationRevisions->last()->quotation_pdf)
                            <a href="{{ $quotation->quotationRevisions->last()->quotation_pdf}}" target="_blank">
                                View
                            </a>
                        @endif
                    @endif
                </td>
                @if ($quotation->quotationRevisions->last())
                    @if ($quotation->quotationRevisions->last()->followUps->last())                        
                        <td>{{ $quotation->quotationRevisions->last()->followUps->last()->follow_up_time}}</td>
                        <td>{{ $quotation->quotationRevisions->last()->followUps->last()->contact_person}}</td>
                        <td>{{ $quotation->quotationRevisions->last()->followUps->last()->remark}}</td>                    
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                @else
                <td></td>
                <td></td>
                <td></td>
                @endif
            </tr>
       @endforeach
       
    </tbody>
</table>

{{ $quotations->appends(array_filter(request()->except('page')))->links() }}