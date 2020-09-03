@php
$progress = optional($saleContract->inHouseInstallation->installationProgresses)->last()->progress ?? 0;
@endphp
<div class="card text-dark" style="margin-bottom: 10px !important;">
    <h4 class="card-header">In-house Installation Progress</h4>

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

        @include('admin.installationProgresses.displayRecords')

        <div class="form-group">
            <form action="{{ route('admin.sale-contracts.installation-progress', ['sale_contract' => $saleContract, 'in_house_installation' => $saleContract->inHouseInstallation]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="progress">Progress ( between 0 and 100 )</label>
                    <input class=form-control type="number" value="{{ old('installation_progress') }}" name="installation_progress" min=0 max=100 required>
                    @if($errors->has('installation_progress'))
                        <span class="text-danger">{{ $errors->first('installation_progress') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="installation_remark">Remark</label>
                    <textarea class=form-control name="installation_remark" value="{{ old('installation_remark') }}" placeholder="Your remark here....."></textarea>
                </div>
                <button type="submit" class="btn btn-save">Update</button>
            </form>
        </div>
    </div>
</div>