<div class="card my-3">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
        
            <a class="nav-item nav-link active" id="inhouse-tab" data-toggle="tab" href="#inhouse-tab-content" role="tab" aria-selected="true">
                In-house Teams
            </a>
            <a class="nav-item nav-link" id="subcom-tab" data-toggle="tab" href="#subcom" role="tab" aria-selected="false">
                Sub-con Teams
            </a>
        </div>
    </nav>
    
    <div class="tab-content" id="nav-tabContent">
    
        <div class="tab-pane fade active show" id="inhouse-tab-content" role="tabpanel" aria-labelledby="enquiry-tab">
            @include('admin.saleContracts.inhouseTeams')
        </div>
        <div class="tab-pane fade" id="subcom" role="tabpanel" aria-labelledby="quotation-tab">
            @include('admin.saleContracts.subcomTeams')
        </div>
    </div>
</div>