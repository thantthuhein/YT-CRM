@extends('layouts.admin')
@section('content')

<div class="card content-card display-card text-white">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subCompany.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            
            <table class="en-list table table-borderless table-striped scrollbar">
                <tbody>                    
                    <tr>
                        <th>
                            {{ trans('cruds.subCompany.fields.company_name') }}
                        </th>
                        <td>
                            {{ $subCompany->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subCompany.fields.contact_person_name') }}
                        </th>
                        <td>
                            {{ $subCompany->contact_person_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subCompany.fields.contact_person_phone_number') }}
                        </th>
                        <td>
                            {{ $subCompany->contact_person_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subCompany.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\SubCompany::IS_ACTIVE_RADIO[$subCompany->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Overall Rating</th>
                        <td>
                            {{ $subCompany->overall_ratings . ' / 5' }} 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subCompany.fields.created_by') }}
                        </th>
                        <td>
                            {{ $subCompany->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subCompany.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $subCompany->updated_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="card display-card">
                <div class="card-header">
                    Installations
                </div>
                <table class="en-list table table-borderless table-striped scrollbar">
                    <thead>
                        <th>Created At</th>
                        <th>Rating</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($subconInstallations as $key => $installation)
                        <tr>
                            <td>
                                {{ $installation->created_at->format('d-M-Y') }}
                            </td>
                            <td>
                                {{ $installation->rating ? $installation->rating . ' / 5' : 'Not Rated Yet' }}
                            </td>
                            <td>
                                @if ($installation->sale_contract->project)
                                <a href="{{ route('admin.sale-contracts.show', $installation->sale_contract_id) }}">{{ $installation->sale_contract->project->name }}</a>    
                                @else                                    
                                <a href="{{ route('admin.sale-contracts.show', $installation->sale_contract_id) }}">Sales Contract {{ ++$key }}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="my-3">
                    {{ $subconInstallations->links() }}
                </div>
            </div>

            <div class="form-group mt-3">
                <a class="btn btn-create" href="{{ route('admin.sub-companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection