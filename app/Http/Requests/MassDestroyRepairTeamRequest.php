<?php

namespace App\Http\Requests;

use App\RepairTeam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRepairTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('repair_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:repair_teams,id',
        ];
    }
}
