<table class="en-list table table-borderless table-striped scrollbar mb-3">
    <tbody>
        
        <tr>
            <th>
                Customer Name
            </th>
            <td>
                {{$saleContract->customer->name}}
            </td>
            <th>
                Phone Number
            </th>
            <td>
                @foreach (optional($saleContract->customer)->customerPhones as $item)
                    {{ $item->phone_number }}, 
                @endforeach
            </td>
        </tr>
        <tr>
            <th>
                Project Name
            </th>
            <td>
                {{ $saleContract->customer->enquiries()->first()->project->name ?? "No Project Description" }}   
            </td>
            <th>
                Location
            </th>
            <td>
                {{ $saleContract->customer->enquiries()->first()->location ?? ""}}   
            </td>
        </tr>
        <tr>
            <th>
                {{ trans('cruds.saleContract.fields.has_installation') }}
            </th>
            <td>
                {{ App\SaleContract::HAS_INSTALLATION_RADIO[$saleContract->has_installation] ?? '' }}
            </td>
            <th>
                {{ trans('cruds.saleContract.fields.installation_type') }}
            </th>
            <td>
                {{-- <a href="{{ route('admin.sale-contracts.teams', [$saleContract]) }}" >{{ App\SaleContract::INSTALLATION_TYPE_SELECT[$saleContract->installation_type] ?? '' }}</a> --}}
                {{ App\SaleContract::INSTALLATION_TYPE_SELECT[$saleContract->installation_type] ?? '' }}
            </td>
        </tr>
        <tr>
            <th>Installation Date</th>
            <td>
                <p>
                    from: {{ $saleContract->inHouseInstallation->actual_start_date ?? 'No Date Yet' }}
                </p>
                <p>
                    to: {{ $saleContract->inHouseInstallation->actual_end_date ?? 'No Date Yet' }}
                </p>
            </td>
            <th>T & C Date</th>
            <td>{{ $saleContract->inHouseInstallation->tc_time ?? 'TC Time Not Set Yet' }}</td>
        </tr>
        <tr> 
            <th>
                {{ trans('cruds.saleContract.fields.payment_status') }}
            </th>
            <td>
                {{ $saleContract->payment_status }} 
            </td>
            <th>
                Installation Status
            </th>
            <td>
                {{ $saleContract->inHouseInstallation->status ?? '' }}
            </td>
        </tr>     
        <tr>
            <th>
                {{ trans('cruds.saleContract.fields.payment_terms') }}
            </th>
            <td>
                {{ $saleContract->payment_terms }}
            </td>
            <th>
                {{ trans('cruds.saleContract.fields.current_payment_step') }}
            </th>
            <td>
                {{ $saleContract->current_payment_step ?? '' }} / {{ $saleContract->payment_terms ?? '' }}
            </td>
        </tr>           
        <tr>
            <th>
                {{ trans('cruds.saleContract.fields.created_by') }}
            </th>
            <td>
                {{ $saleContract->created_by->name ?? '' }}
            </td>
            <th>
                {{ trans('cruds.saleContract.fields.updated_by') }}
            </th>
            <td>
                {{ $saleContract->updated_by->name ?? '' }}
            </td>
        </tr>
    </tbody>
</table>