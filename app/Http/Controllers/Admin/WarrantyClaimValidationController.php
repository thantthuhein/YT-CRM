<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWarrantyClaimValidationRequest;
use App\Http\Requests\StoreWarrantyClaimValidationRequest;
use App\Http\Requests\UpdateWarrantyClaimValidationRequest;
use App\RepairTeam;
use App\User;
use App\WarrantyClaim;
use App\WarrantyClaimValidation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyClaimValidationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('warranty_claim_validation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimValidations = WarrantyClaimValidation::all();

        return view('admin.warrantyClaimValidations.index', compact('warrantyClaimValidations'));
    }

    public function create()
    {
        abort_if(Gate::denies('warranty_claim_validation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair_teams = RepairTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.warrantyClaimValidations.create', compact('repair_teams', 'created_bies', 'updated_bies'));
    }

    public function store(WarrantyClaim $warrantyClaim, StoreWarrantyClaimValidationRequest $request)
    {
        // dd('here');
        $userId = auth()->user()->id;

        $data = $request->all();

        if($warrantyClaim->warranty_claim_validation){
            $data['updated_by_id'] = $userId;

            if($data['repair_team_id']){
                $warrantyClaim->warranty_claim_validation()->update([
                    'repair_team_id' => $data['repair_team_id'],
                    'actual_date' => $data['actual_date'],
                    'updated_by_id' => $userId
                ]);
            }
            else{
                $warrantyClaim->warranty_claim_validation()->update([
                    'actual_date' => $data['actual_date'],
                    'updated_by_id' => $userId
                ]);
            }
        }
        else{
            $data['created_by_id'] = $userId;
            $warrantyClaimValidation = WarrantyClaimValidation::create($data);
            $warrantyClaim->warranty_claim_validation_id = $warrantyClaimValidation->id;
            $warrantyClaim->update();
        }

        return redirect()->route('admin.warranty-claims.show', [$warrantyClaim]);
    }

    public function edit(WarrantyClaimValidation $warrantyClaimValidation)
    {
        abort_if(Gate::denies('warranty_claim_validation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair_teams = RepairTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warrantyClaimValidation->load('repair_team', 'created_by', 'updated_by');

        return view('admin.warrantyClaimValidations.edit', compact('repair_teams', 'created_bies', 'updated_bies', 'warrantyClaimValidation'));
    }

    public function update(UpdateWarrantyClaimValidationRequest $request, WarrantyClaimValidation $warrantyClaimValidation)
    {
        $warrantyClaimValidation->update($request->all());

        return redirect()->route('admin.warranty-claim-validations.index');
    }

    public function show(WarrantyClaimValidation $warrantyClaimValidation)
    {
        abort_if(Gate::denies('warranty_claim_validation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimValidation->load('repair_team', 'created_by', 'updated_by');

        return view('admin.warrantyClaimValidations.show', compact('warrantyClaimValidation'));
    }

    public function destroy(WarrantyClaimValidation $warrantyClaimValidation)
    {
        abort_if(Gate::denies('warranty_claim_validation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimValidation->delete();

        return back();
    }

    public function massDestroy(MassDestroyWarrantyClaimValidationRequest $request)
    {
        WarrantyClaimValidation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
