<div class="card text-dark" style="margin-bottom: 10px !important;">
    <h4 class="card-header">Add Installation Teams</h4>

    <div class="card-body">
        <form action="{{ route('admin.sale-contracts.add-installation-teams', ['sale_contract' => $saleContract, 'in_house_installation' => $saleContract->inHouseInstallation]) }}" method="POST">
            @csrf
            <div class="form-group row align-items-center">
                <label for="" class='col-sm-2'>Service Teams</label>
                <div class="form-group col-sm-5" style="margin: 0;">
                    <select name="servicing_team_id" class='form-control'>
                        @foreach($servicing_teams as $id => $servicing_team)
                            <option value="{{ $id }}" {{ old('servicing_team_id') == $id ? 'selected' : '' }}>{{ $servicing_team }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('servicing_team_id'))
                        <span class="text-danger">{{ $errors->first('servicing_team_id') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-save ml-4">Add</button>
            </div>
        </form>
    </div>
</div>