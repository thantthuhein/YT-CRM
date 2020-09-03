<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.sale-contracts.createDocumentPdf', [$saleContract]) }}" class="btn btn-sm btn-save">
            <i class="fas fa-cloud-upload-alt"></i> &nbsp;Upload
        </a>
    </div>

    <div class="card-body p-0">           
        @if ($saleContractDocs->isEmpty())
            No Records Yet
        @else            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
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
                        @foreach($saleContractDocs as $key => $saleContractPdf)
                            <tr>
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

