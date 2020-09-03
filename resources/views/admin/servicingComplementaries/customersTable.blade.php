@if ( isset($sale_contracts) )
<table class="table">

    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Installation Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $sale_contracts as $sale_contract )
            <tr>
                <td>{{ $sale_contract->customer->name }}</td>
                <td>{{ $sale_contract->installation_type }}</td>
                <td>
                    <a 
                    href="{{ route('admin.servicing-complementaries.make', ['sale_contract_id' => $sale_contract->id]) }}" 
                    class="btn btn-sm btn-primary rounded-pill">
                        Make Complementary
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>

<div>{{ $sale_contracts->links() }}</div>
@endif