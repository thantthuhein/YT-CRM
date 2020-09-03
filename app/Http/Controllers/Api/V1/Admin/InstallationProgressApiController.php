<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstallationProgressRequest;
use App\Http\Requests\UpdateInstallationProgressRequest;
use App\Http\Resources\Admin\InstallationProgressResource;
use App\InstallationProgress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstallationProgressApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('installation_progress_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InstallationProgressResource(InstallationProgress::with(['inhouse_installation', 'created_by', 'latest_updated_by'])->get());
    }

    public function store(StoreInstallationProgressRequest $request)
    {
        $installationProgress = InstallationProgress::create($request->all());

        return (new InstallationProgressResource($installationProgress))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(InstallationProgress $installationProgress)
    {
        abort_if(Gate::denies('installation_progress_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InstallationProgressResource($installationProgress->load(['inhouse_installation', 'created_by', 'latest_updated_by']));
    }

    public function update(UpdateInstallationProgressRequest $request, InstallationProgress $installationProgress)
    {
        $installationProgress->update($request->all());

        return (new InstallationProgressResource($installationProgress))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(InstallationProgress $installationProgress)
    {
        abort_if(Gate::denies('installation_progress_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $installationProgress->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
