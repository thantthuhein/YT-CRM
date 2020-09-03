@if ($inHouseInstallation->servicingContracts->isEmpty())
    <div class="text-center mt-3">
        <h5 class="text-center">No Records Yet</h5>
        <a 
            href="{{ route('admin.servicing-contracts.create', [
                'project_id' =>  optional($inHouseInstallation->sale_contract)->project->id ?? "", 
                'inhouse_installation_id' => $inHouseInstallation->id
                ]) }}" 
            class="btn btn-save btn-sm {{ $inHouseInstallation->servicingContracts->isEmpty() ? '' : 'disabled' }}"
            >
            Create Servicing Contract
        </a>            
    </div>
@else    
    @if ($inHouseInstallation->servicingContracts)                                            
        <div class="table-responsive scrollbar my-2">
            <table class="en-list table table-borderless table-striped scrollbar text-dark">
                <thead>
                    <tr>
                        <th>
                            Created At
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.interval') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.contract_start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.contract_end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingContract.fields.updated_by') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inHouseInstallation->servicingContracts as $key => $servicingContract)
                        <tr>
                            <td>
                                {{ $servicingContract->created_at->format('M-d-Y') }}
                            </td>
                            <td>
                                {{ $servicingContract->project->name ?? '' }}
                            </td>
                            <td>
                                {{ App\ServicingContract::INTERVAL_RADIO[$servicingContract->interval] ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->contract_start_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->contract_end_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $servicingContract->updated_by->name ?? '' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-sm btn-save mr-2" href="{{ route('admin.servicing-contracts.show', $servicingContract->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                </div>
                            </td>
        
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif