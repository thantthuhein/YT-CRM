<div class="card p-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            
                        </th>
                        <th>
                            Company Name
                        </th>
                        <th>
                            Contact Person
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            Active
                        </th>
                        <th>
                            Installation Type
                        </th>
                        <th>
                            Completed Date
                        </th>
                        <th>
                            Rating
                        </th>
                        <th>
                            
                        </th>
                        <th>
        
                        </th>
                    </tr>
                </thead>
        
        
                @if(count($saleContract->subComInstallations) > 0)
                    @foreach($saleContract->subComInstallations as $key => $subcom)
                        <tbody>
                            <tr data-entry-id="{{ $subcom->id }}">
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $subcom->subCompany()->company_name ?? '' }}
                                </td>
                                <td>
                                    {{ $subcom->subCompany()->contact_person_name ?? '' }}
                                </td>
                                <td>
                                    {{ $subcom->subCompany()->contact_person_phone_number ?? ""}}
                                </td>
                                <td>
                                    {{ $subcom->subCompany()->is_active ? 'TRUE' : "FALSE" }}
                                </td>
                                <td>
                                    {{ $subcom->installation_type }}
                                </td>
                                <td>
                                    {{ $subcom->completed_month }} - {{ $subcom->completed_year }}
                                </td>
                                <td>
                                    {{ $subcom->rating ?? '' }} / 5
                                    {{-- {{ $subcom->subComInstallations }}  --}}
                                </td>
                                <td>
                                    <a href="{{ route('admin.sub-com-installations.edit', [$subcom])}}" class='btn btn-sm btn-save'>
                                        <i class="far fa-star"></i> Rate
                                    </a>                            
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <form action="{{ route('admin.sub-com-installations.destroy', $subcom) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        >
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger ml-2">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>