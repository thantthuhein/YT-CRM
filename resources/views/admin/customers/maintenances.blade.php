<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Servicing Complementaries</th>
                    <th>Servicing Contracts</th>
                    <th>Service Calls</th>
                </tr>
            </thead>

            <tbody>
                @if ( ! $customer->enquiries->isEmpty())                    
                    @foreach ($customer->enquiries as $enquiry)
                    <tr>
                        <td>
                            @php
                                $complementary = 1;
                            @endphp
                            @if ($enquiry->saleContract)                                    
                                @if ($enquiry->saleContract->inHouseInstallation)          
                                    @foreach ($enquiry->saleContract->inHouseInstallation->servicingComplementaries as $servicingComplementary)
                                        <p>
                                            <a 
                                            href="{{ route('admin.servicing-complementaries.show', $servicingComplementary) }}">
                                            Servicing Complementary {{ $complementary++ }}
                                            </a>        
                                        </p>
                                    @endforeach
                                @endif
                            @endif
                        </td>
                        <td>
                            @php
                                $contract = 1;
                            @endphp
                            @if ($enquiry->saleContract)                                    
                                @if ($enquiry->saleContract->inHouseInstallation)                                    
                                    @foreach ($enquiry->saleContract->inHouseInstallation->servicingContracts as $servicingContract)
                                        <p>
                                            <a 
                                            href="{{ route('admin.servicing-contracts.show', $servicingContract) }}">
                                            Servicing Contract {{ $contract++ }}
                                            </a>
                                        </p>
                                    @endforeach
                                @endif
                            @endif
                        </td>
                        <td>
                            @php
                                $serviceCall = 1;
                            @endphp
                            @if ($enquiry->saleContract)            
                                @if ($enquiry->saleContract->on_calls)                                    
                                    @foreach ($enquiry->saleContract->on_calls as $on_call)
                                        @foreach ($on_call->servicingSetups as $servicingSetup)
                                            <p>
                                                <a href="{{ route('admin.servicing-setups.show', $servicingSetup) }}">
                                                    Service Call {{ $serviceCall++ }}
                                                </a>
                                            </p>
                                        @endforeach
                                    @endforeach
                                @endif                        
                            @endif
                        </td>
                    </tr>                        
                    @endforeach    
                @endif                
                @if(! $customer->quotations->isEmpty())
                    @foreach ($customer->quotations as $quotation)
                    <tr>
                        <td>
                            @php
                                $complementary = 1;
                            @endphp
                            @if ($quotation->saleContract)                                    
                                @if ($quotation->saleContract->inHouseInstallation)          
                                    @foreach ($quotation->saleContract->inHouseInstallation->servicingComplementaries as $servicingComplementary)
                                        <p>
                                            <a 
                                            href="{{ route('admin.servicing-complementaries.show', $servicingComplementary) }}">
                                            Servicing Complementary {{ $complementary++ }}
                                            </a>        
                                        </p>
                                    @endforeach
                                @endif
                            @endif
                        </td>
                        <td>
                            @php
                                $contract = 1;
                            @endphp
                            @if ($quotation->saleContract)                                    
                                @if ($quotation->saleContract->inHouseInstallation)                                    
                                    @foreach ($quotation->saleContract->inHouseInstallation->servicingContracts as $servicingContract)
                                        <p>
                                            <a 
                                            href="{{ route('admin.servicing-contracts.show', $servicingContract) }}">
                                            Servicing Contract {{ $contract++ }}
                                            </a>
                                        </p>
                                    @endforeach
                                @endif
                            @endif
                        </td>
                        <td>
                            @php
                                $serviceCall = 1;
                            @endphp
                            @if ($quotation->saleContract)            
                                @if ($quotation->saleContract->on_calls)                                    
                                    @foreach ($quotation->saleContract->on_calls as $on_call)
                                        @foreach ($on_call->servicingSetups as $servicingSetup)
                                            <p>
                                                <a href="{{ route('admin.servicing-setups.show', $servicingSetup) }}">
                                                    Service Call {{ $serviceCall++ }}
                                                </a>
                                            </p>
                                        @endforeach
                                    @endforeach
                                @endif                        
                            @endif
                        </td>
                    </tr>                        
                    @endforeach 
                @endif
            </tbody>
        </table>

    </div>
</div>