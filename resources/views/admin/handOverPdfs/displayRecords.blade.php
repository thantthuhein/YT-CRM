<div class="card p-0">
    @if ($saleContract->inHouseInstallation)        
    <div class="card-body p-0">
        @if ($saleContract->inHouseInstallation->handOverPdfs->isEmpty())
        <div class="text-center my-3">
            
            @if(! $saleContract->inHouseInstallation->hand_over_date)
                <a class="btn btn-save btn-sm text" href="{{ route('admin.sale-contracts.inhouseInstallation.addCompletedData', [$saleContract, $saleContract->inHouseInstallation]) }}">
                    Add Completed Data
                </a>
            @else
                <a class="btn btn-save btn-sm text" href="{{ route('admin.in-house-installations.hand-over-pdfs.store', [$saleContract->inHouseInstallation]) }}">
                    Upload Handover Files
                </a>
            @endif
        </div>
        @else
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.in-house-installations.hand-over-pdfs.store', [$saleContract->inHouseInstallation]) }}"
                    class="btn btn-sm btn-save">
                        <i class="fas fa-plus-circle"></i> Add 
                    </a>                    
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <td>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($saleContract->inHouseInstallation->handOverPdfs as $key => $handOverPdf)
                                    <tr>
                                        <td>
                                            {{ ++$key }}
                                        </td>
                                        <td>
                                            {{ $handOverPdf->type }}
                                        </td>
                                        <td>
                                            <a href="{{ $handOverPdf->url }}" class='btn btn-sm btn-primary rounded-pill' target="_blank">
                                                <i class="far fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @else
        No Records Yet
    @endif
</div>