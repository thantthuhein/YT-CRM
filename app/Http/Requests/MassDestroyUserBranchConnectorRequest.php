<?php

namespace App\Http\Requests;

use App\UserBranchConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserBranchConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_branch_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:user_branch_connectors,id',
        ];
    }
}
