<div class="card">
    <div class="card-header">
        @can('upload_other_docs_create')
        @if($saleContract->has_installation)
            <a href="{{ route("admin.sale-contracts.upload-other-documents", [$saleContract]) }}" class="btn btn-sm btn-save">
                <i class="fas fa-cloud-upload-alt"></i> &nbsp;Upload Other Docs
            </a>
        @endif                    
        @endcan
    </div>

    <div class="card-body p-0">           
        @if ($docsForServiceManager->isEmpty())
            No Records Yet
        @else            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.saleContractPdf.fields.iteration') }}
                            </th>
                            <th>
                                {{ trans('cruds.saleContractPdf.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.saleContractPdf.fields.uploaded_by') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docsForServiceManager as $key => $saleContractPdf)
                            <tr>
                                <td>
                                    {{ $saleContractPdf->iteration ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContractPdf->title ?? '' }}
                                </td>
                                <td>
                                    {{ $saleContractPdf->uploaded_by->name ?? '' }}
                                </td>
                                <td>
                                    <a href="{{ $saleContractPdf->url }}" class="btn btn-sm btn-primary rounded-pill" target="_blank"><i class="far fa-eye"></i> View</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif   
        
    </div>
</div>

