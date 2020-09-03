<?php

namespace App\Http\Requests;

use App\InhouseInstallationTeam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyInhouseInstallationTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('inhouse_installation_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:inhouse_installation_teams,id',
        ];
    }
}
