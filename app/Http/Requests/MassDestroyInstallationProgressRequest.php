<?php

namespace App\Http\Requests;

use App\InstallationProgress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyInstallationProgressRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('installation_progress_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:installation_progresses,id',
        ];
    }
}
