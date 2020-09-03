<table class="en-list table table-borderless table-striped scrollbar">
    <thead>
        <tr>
            <th width="10">
                #
            </th>
            <th>Project</th>
            <th>Customer</th>
            <th>Company</th>
            <th>Air-con Types</th>
            <th>Quotation Number</th>
            <th>Last Quotated Date</th>
            <th>Last Revision PDF</th>
            <th>Installation Type</th>
            <th>Payment</th>
            <th>Payment Status</th>
            <th>Created B</th>
        </tr>
    </thead>
    <tbody>
    @php
        $order = order(request()->page ?? 1, $saleContracts->perPage())
    @endphp
    @foreach($saleContracts as $saleContract)
        @php
            $hasQuotation = false;
            if($saleContract->morphableName == 'Quotation')
            {
                $hasQuotation = true;
            }
        @endphp
        <tr>
            <td>{{ $order++ }}</td>
            <td>{{ $saleContract->project->name ?? "N/A" }}</td>
            <td>{{ $saleContract->customer->name }}</td>
            <td>{{ $saleContract->company->name ?? "N/A" }}</td>
            <td>{{ implode(', ', $saleContract->airconTypes->pluck('type')->toArray()) }}</td>
            <td>{{ $hasQuotation ? $saleContract->morphableEnquiryQuotation->number : "NONE" }}</td>
            <td>{{ $hasQuotation ? ($saleContract->morphableEnquiryQuotation->quotationRevisions->last()->quoted_date ?? "N/A") : "NONE" }}</td>
            <td>
                @if ($hasQuotation)
                    @if (isset($saleContract->morphableEnquiryQuotation->quotationRevisions->last()->quotation_pdf))
                        <a href="{{ $saleContract->morphableEnquiryQuotation->quotationRevisions->last()->quotation_pdf }}" target="_blank" 
                        class="btn btn-sm btn-primary">View</a>
                    @else
                        <p>N/A</p>
                    @endif
                @else
                    <p>NONE</p>
                @endif
            <td>{{ $saleContract->installation_type }}</td>
            <td>{{ $saleContract->current_payment_step .'/' .$saleContract->payment_terms }}</td>
            <td>{{ $saleContract->payment_status ?? 'NULL' }}</td>
            <td>{{ $saleContract->created_by->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $saleContracts->appends(array_filter(request()->except('page')))->links() }}