<div class="card my-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item p-0">
            <a class="nav-link active" id="service-complementary-tab" data-toggle="tab" href="#service-complementary" role="tab" aria-controls="service-complementary" aria-selected="true">Servicing Complementaries</a>
        </li>
        <li class="nav-item p-0">
            <a class="nav-link" id="service-contract-tab" data-toggle="tab" href="#service-contract" role="tab" aria-controls="service-contract" aria-selected="false">Servicing Contracts</a>
        </li>
    </ul>

    <div class="tab-content text-dark" id="myTabContent">
        <div class="tab-pane fade show active" id="service-complementary" role="tabpanel" aria-labelledby="service-complementary-tab">
            @include('admin.inHouseInstallations.servicingComplementaries')
        </div>

        <div class="tab-pane fade" id="service-contract" role="tabpanel" aria-labelledby="service-contract-tab">
            @include('admin.inHouseInstallations.servicingContracts')
        </div>
    </div>
</div>