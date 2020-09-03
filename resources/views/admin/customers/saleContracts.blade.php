<div class="card">
    <div class="card-body">
        {{-- <p>{{ $customer->enquiries->first()->saleContract }}</p> --}}
        @if (! $saleContracts->isEmpty())                
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Has Installation</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($saleContracts as $saleContract)
                        <tr>
                            <td>{{ $saleContract->has_installation == true ? 'Yes' : 'No' }}</td>
                            <td>{{ $saleContract->considerPaymentStatus() }}</td>
                            <td>
                                <a href="{{ route('admin.sale-contracts.show', $saleContract->id) }}" 
                                class="btn btn-sm btn-primary rounded-pill">View</a>
                            </td>
                        </tr>
                    @endforeach                
                    {{-- @if ( ! $customer->enquiries->isEmpty())
                        @foreach ($customer->enquiries as $enquiry)
                            <tr>
                                @if ($enquiry->saleContract)
                                <td>{{ $enquiry->saleContract->has_installation == true ? 'Yes' : 'No' }}</td>
                                <td>{{ $enquiry->saleContract->considerPaymentStatus() }}</td>
                                <td>
                                    <a href="{{ route('admin.sale-contracts.show', $enquiry->saleContract->id) }}" 
                                    class="btn btn-sm btn-primary rounded-pill">View</a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    @if (! $customer->quotations->isEmpty())
                        @foreach ($customer->quotations as $quotation)
                            <tr>
                                @if ($quotation->saleContract)
                                <td>{{ $quotation->saleContract->has_installation == true ? 'Yes' : 'No' }}</td>
                                <td>{{ $quotation->saleContract->considerPaymentStatus() }}</td>
                                <td>
                                    <a href="{{ route('admin.sale-contracts.show', $quotation) }}" 
                                    class="btn btn-sm btn-primary rounded-pill">View</a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif --}}
                </tbody>
            </table>
        @else
            No Sale Contracts
        @endif

    </div>
</div>