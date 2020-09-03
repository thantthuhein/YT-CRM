<?php

namespace App\Http\Requests;

use App\InstallationProgress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateInstallationProgressRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('installation_progress_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'progress' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }
}
