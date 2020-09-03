@if ($saleContract->inHouseInstallation)
    <div class="card display-card">
        
        @if ($handOverPdfs->isEmpty())
            <p class="text-center">No Handover PDF yet</p>
        @else        
            <div class="table-responsive">
                <table class="en-list table table-borderless table-striped scrollbar">
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
                        @foreach($handOverPdfs as $key => $handOverPdf)
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

                <div class="my-3">
                    {{ $handOverPdfs->links() }}
                </div>
            </div>
        @endif

    </div>
@endif