<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable">
        <thead>
            <tr>
                <th>
                    Progress
                </th>
                <th>
                    Remark
                </th>
                <th>
                    PDF
                </th>
                <th>
                    Delivered On
                </th>
                <th>
                    Created by
                </th>
                <th>
                    Last Updated by
                </th>
                <th>
                </th>
            </tr>
        </thead>
        <tbody>
            @if($saleContract->inHouseInstallation)
                @foreach($saleContract->inHouseInstallation->materialDeliveryProgresses as $materialProgress)
                    <tr>
                        <td>
                            {{ $materialProgress->progress }}
                        </td>
                        <td>
                            {{ $materialProgress->remark }}
                        </td>
                        <td>
                            @foreach($materialProgress->material_delivery_pdfs as $key => $pdf)
                                <span style="display: block">
                                    File {{ ++$key }} : <a href="{{ $pdf->pdf }}" target="_blank">View</a>
                                </span>
                            @endforeach
                        </td>
                        <td>
                            {{ $materialProgress->delivered_at ?? ""}}
                        </td>
                        <td>
                            {{ $materialProgress->created_by->name ?? "" }}
                        </td>
                        <td>
                            {{ $materialProgress->last_updated_by->name ?? "" }}
                        </td>
                        <td>
                            <a href="{{ route('admin.material-delivery-progresses.edit', [$materialProgress])}}" class='btn btn-default rounded-pill'>
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>