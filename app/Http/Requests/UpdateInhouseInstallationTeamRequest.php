<?php

namespace App\Http\Requests;

use App\InhouseInstallationTeam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateInhouseInstallationTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('inhouse_installation_team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
