<div class="card text-dark">
    <h4 class="card-header">Material Delivery Progress ( For In-house Installation )</h4>
    @php
        $progress = optional($saleContract->inHouseInstallation->materialDeliveryProgresses)->last()->progress ?? 0
    @endphp
    <div class="card-body">
        <div class="progress" style="height: 15px; margin-bottom: 10px">
            @if ($progress == 100)
                <div class="progress-bar bg-success"    
            @elseif ($progress <= 99 && $progress >= 70 )
                <div class="progress-bar bg-primary"
            @elseif ($progress < 70 && $progress >= 40)
                <div class="progress-bar bg-warning"
            @elseif ($progress < 40 && $progress >= 15)
                <div class="progress-bar bg-secondary"
            @elseif ($progress < 15)
                <div class="progress-bar bg-danger text-dark"
            @endif
            
            role="progressbar" style="color: black;width: {{ $progress }}%;" value={{ $progress }} aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                {{ $progress == 100 ? "Completed" : "Current" }} {{ $progress ?? 0}}%
            </div>
        </div>

        @include('admin.materialDeliveryProgresses.displayRecords')

        <div class="form-group">
            <form action="{{ route('admin.sale-contracts.inhouse-installations.material-delivery-progress', ['sale_contract' => $saleContract, 'in_house_installation' => $saleContract->inHouseInstallation]) }}" method="POST" enctype="multipart/form-data" onsubmit="loadSpinner()">
                @csrf
                <div class="form-group">
                    <label for="progress">Progress ( between 0 and 100 )</label>
                    <input class=form-control type="number" value="{{ old('progress') }}" name="progress" min=0 max=100 required>
                    @if($errors->has('progress'))
                        <span class="text-danger">{{ $errors->first('progress') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">PDF</label>
                    <input type="file" class='form-control' name="material_pdf[]" multiple accept="application/pdf">
                    @if($errors->has('material_pdf.*') || $errors->has('material_pdf'))
                        <span class="text-danger">{{ $errors->first('material_pdf') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="delivered_at">Delivered On</label>
                    <input class="form-control date {{ $errors->has('delivered_at') ? 'is-invalid' : '' }}" type="text" name="delivered_at" id="delivered_at" value="{{ old('delivered_at') }}">
                    @if($errors->has('delivered_at'))
                        <span class="text-danger">{{ $errors->first('delivered_at') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="progress">Remark</label>
                    <textarea class=form-control name="remark" placeholder="Your remark here.....">{{old('remark')}}</textarea>
                    @if($errors->has('remark'))
                        <span class="text-danger">{{ $errors->first('remark') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-save" id="material-delivery-progressing-upload">Update</button>
            </form>
        </div>
    </div>
</div>
