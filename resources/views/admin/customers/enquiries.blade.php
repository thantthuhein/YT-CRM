<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Enquiry Type</th>
                    <th>Type Of Sales</th>
                    <th>Sale Engineer</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @if ( ! $customer->enquiries->isEmpty())                    
                    @foreach ($customer->enquiries as $enquiry)
                        <tr>
                            <td>{{ $enquiry->created_at->format('d-D-M-Y') ?? ''}}</td>
                            <td>{{ $enquiry->enquiries_type->type ?? ''}}</td>
                            <td>{{ $enquiry->type_of_sales->type ?? '' }}</td>
                            <td>{{ $enquiry->user->name ?? '' }}</td>
                            <td>{{ $enquiry->status ?? '' }}</td>
                            <td>
                                <a href="{{ route('admin.enquiries.show', $enquiry) }}" 
                                class="btn btn-sm btn-primary rounded-pill">View</a>
                            </td>
                        </tr>                        
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>