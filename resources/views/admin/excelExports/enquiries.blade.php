<table class="en-list table table-borderless table-striped scrollbar">
    <thead>
        <tr>
            <th width="10">
                #
            </th>
            <th>
                Created At
            </th>
            <th>
                Project
            </th>
            <th>
                Customer
            </th>
            <th>
                Company
            </th>
            <th>
                Location
            </th>
            <th>
                Air-con Types
            </th>
            <th>
                Receiver Name
            </th>
            <th>
                Status
            </th>
            <th>
                Sales Engineer
            </th>
        </tr>
    </thead>
    <tbody>
        @php
            $order = order(request()->page ?? 1, $enquiries->perPage())
        @endphp
       @foreach($enquiries as $enquiry)
            <tr>
                <td>{{ $order++ }}</td>
                <td>{{ $enquiry->created_at->format('d-D-M-Y') }}</td>
                <td>{{ $enquiry->project->name ?? "N/A" }}</td>
                <td>{{ $enquiry->customer->name }}</td>
                <td>{{ $enquiry->company->name ?? "N/A"}}</td>
                <td>{{ $enquiry->location }}</td>
                <td>{{ implode(', ', $enquiry->airconTypes->pluck('type')->toArray()) }}</td>
                <td>{{ $enquiry->receiver_name }}</td>
                <td>{{ $enquiry->status }}</td>
                <td>{{ $enquiry->created_by->name }}</td>
            </tr>
       @endforeach
    </tbody>
</table>

{{ $enquiries->appends(array_filter(request()->except('page')))->links() }}