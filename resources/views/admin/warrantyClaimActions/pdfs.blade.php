<div class="card text-dark mb-3">
    <h5 class="card-header">
        Warranty Claim Action
    </h5>

    <div class="card-body">
        <table class="table table-striped mb-2">
            <thead>
                <tr>
                    <td>
                        <h5>Daikin representative</h5>
                        <label>Name - </label> {{ $warrantyClaim->warranty_claim_action->daikin_rep_name }} <br/>
                        <label>Phone number - </label> {{ $warrantyClaim->warranty_claim_action->daikin_rep_phone_number }}
                    </td>
                    <td>
                        <br>
                        <label>Estimated date - </label> {{ $warrantyClaim->warranty_claim_action->estimate_date}} <br>
                        <label>Actual date - </label> {{ $warrantyClaim->warranty_claim_action->actual_date}}
                    </td>
                </tr>
            </thead>
        </table>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>Service Report PDF for Ywar Taw</th>
                    <td>
                        @if ($warrantyClaim->warranty_claim_action->service_report_pdfs_for_ywartaw)
                            @php
                                $order = 1;
                            @endphp
                            <div class="d-flex">
                                @foreach ($warrantyClaim->warranty_claim_action->service_report_pdfs_for_ywartaw as $report_pdf)                                
                                <a 
                                href="{{ $report_pdf->url }}" 
                                class="btn btn-sm btn-info ml-1"
                                target="_blank"
                                >PDF {{ $order++ }}</a>

                                @endforeach
                            </div>                            
                        @endif 
                    </td>
                </tr>
                <tr>
                    <th>Service Report PDF for Daikin</th>
                    <td>
                        @if ($warrantyClaim->warranty_claim_action->service_report_pdfs_for_daikin)
                            @php
                                $order = 1;
                            @endphp
                            <div class="d-flex">
                                @foreach ($warrantyClaim->warranty_claim_action->service_report_pdfs_for_daikin as $report_pdf)                                
                                <a 
                                href="{{ $report_pdf->url }}" 
                                class="btn btn-sm btn-info ml-1"
                                target="_blank"
                                >PDF {{ $order++ }}</a>

                                @endforeach
                            </div>                            
                        @endif 
                    </td>
                </tr>
                <tr>
                    <th>Delivery Order</th>
                    <td>
                        @if ($warrantyClaim->warranty_claim_action->deliver_order_pdfs)
                            @php
                                $order = 1;
                            @endphp
                            <div class="d-flex">
                                @foreach ($warrantyClaim->warranty_claim_action->deliver_order_pdfs as $report_pdf)                                
                                <a 
                                href="{{ $report_pdf->url }}" 
                                class="btn btn-sm btn-info ml-1"
                                target="_blank"
                                >PDF {{ $order++ }}</a>

                                @endforeach
                            </div>                            
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-striped my-2">
            <thead>
                <tr>
                    <th>Remark</th>
                    <th>Added by</th>
                    <th>Added at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warrantyClaim->warranty_claim_action->remarks as $remark)
                    <tr>
                        <td>{{ $remark->remark }}</td>
                        <td>{{ $remark->created_by->name }}</td>
                        <td>{{ $remark->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>