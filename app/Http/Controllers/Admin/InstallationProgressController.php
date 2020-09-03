<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInstallationProgressRequest;
use App\Http\Requests\StoreInstallationProgressRequest;
use App\Http\Requests\UpdateInstallationProgressRequest;
use App\InHouseInstallation;
use App\InstallationProgress;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstallationProgressController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('installation_progress_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $installationProgresses = InstallationProgress::all();

        return view('admin.installationProgresses.index', compact('installationProgresses'));
    }

    public function create()
    {
        abort_if(Gate::denies('installation_progress_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouse_installations = InHouseInstallation::all()->pluck('estimate_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $latest_updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.installationProgresses.create', compact('inhouse_installations', 'created_bies', 'latest_updated_bies'));
    }

    public function store(StoreInstallationProgressRequest $request)
    {
        $installationProgress = InstallationProgress::create($request->all());

        return redirect()->route('admin.installation-progresses.index');
    }

    public function edit(InstallationProgress $installationProgress)
    {
        abort_if(Gate::denies('installation_progress_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $installationProgress->load('inhouse_installation', 'created_by', 'latest_updated_by');

        return view('admin.installationProgresses.edit', compact('installationProgress'));
    }

    public function update(UpdateInstallationProgressRequest $request, InstallationProgress $installationProgress)
    {
        $userId = auth()->user()->id;

        $updatedData = $request->all();

        $updatedData['latest_updated_by_id'] = $userId;
        $installationProgress->update($updatedData);

        /**
         * check and update status
         * 
         */
        $lastProgress = (new InstallationProgress)->lastProgress($installationProgress->inhouse_installation->id);

        if($lastProgress == 100){
            /**
             * Set status to complete
             */
            $installationProgress->inhouse_installation->status = config('status.installation_status.complete');
            
        } 
        else{
            /**
             * Set status to ongoing
             */
            $installationProgress->inhouse_installation->status = config('status.installation_status.ongoing');
        }
        $installationProgress->inhouse_installation->update();

        return redirect()->route('admin.in-house-installations.show', [$installationProgress->inhouse_installation]);
    }

    public function show(InstallationProgress $installationProgress)
    {
        abort_if(Gate::denies('installation_progress_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $installationProgress->load('inhouse_installation', 'created_by', 'latest_updated_by');

        return view('admin.installationProgresses.show', compact('installationProgress'));
    }

    public function destroy(InstallationProgress $installationProgress)
    {
        abort_if(Gate::denies('installation_progress_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $installationProgress->delete();

        return back();
    }

    public function massDestroy(MassDestroyInstallationProgressRequest $request)
    {
        InstallationProgress::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
