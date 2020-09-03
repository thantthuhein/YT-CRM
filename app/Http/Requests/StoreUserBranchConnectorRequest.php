<?php

namespace App\Http\Requests;

use App\UserBranchConnector;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreUserBranchConnectorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_branch_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
