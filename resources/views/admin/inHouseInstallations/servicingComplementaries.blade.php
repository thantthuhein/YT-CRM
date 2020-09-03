@if ($inHouseInstallation->servicingComplementaries->isEmpty())
    <div class="text-center mt-3">
        <h5 class="text-center">No Records Yet</h5>
        @if ($inHouseInstallation->tc_time != NULL)                        
            {{-- disable if there no complementaries --}}
            <form action="{{ route('admin.servicing-complementaries.store') }}" method="POST">
                @csrf
                <input type="hidden" 
                name="project_id" 
                value="{{ $inHouseInstallation->sale_contract->project->id ?? '' }}">

                <input type="hidden" name="inhouse_installation_id" 
                value="{{ $inHouseInstallation->id }}">

                <input type="hidden" name="request_type" 
                value="{{ config('servicingSetup.request_type_complementary') }}">

                <button 
                {{ $inHouseInstallation->servicingComplementaries->isEmpty() ? '' : 'disabled' }}
                type="submit" class="btn btn-save btn-sm">Create Complementary Service</button>
            </form>
        @else
            Upload T&C Date To Create Servicing Complementary
        @endif
    </div>
@else    
    @if ($inHouseInstallation->servicingComplementaries)                                        
        <div class="table-responsive scrollbar my-2">
            <table class="en-list table table-borderless table-striped scrollbar text-dark">
                <thead>
                    <tr>
                        <th>
                            Created At
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.inhouse_installation') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.first_maintenance_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicingComplementary.fields.second_maintenance_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inHouseInstallation->servicingComplementaries as $key => $servicingComplementary)
                        <tr data-entry-id="{{ $servicingComplementary->id }}">
                            <td>
                                {{ $servicingComplementary->created_at->format('M-d-Y') ?? '' ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->inhouse_installation->estimate_start_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->project->name ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->first_maintenance_date ?? '' }}
                            </td>
                            <td>
                                {{ $servicingComplementary->second_maintenance_date ?? '' }}
                            </td>
                            <td>
                                <a class="btn btn-sm btn-save px-2 mr-2" href="{{ route('admin.servicing-complementaries.show', $servicingComplementary->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif