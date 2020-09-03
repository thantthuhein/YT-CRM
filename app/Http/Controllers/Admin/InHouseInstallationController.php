<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\SaleContract;
use App\ServicingTeam;
use App\HandOverChecklist;
use App\InHouseInstallation;
use Illuminate\Http\Request;
use App\InhouseInstallationTeam;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreInHouseInstallationRequest;
use App\Http\Requests\UpdateInHouseInstallationRequest;
use App\Http\Requests\MassDestroyInHouseInstallationRequest;
use App\Jobs\CompletingSaleContractEstimatedDateJob;

class InHouseInstallationController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('in_house_installation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inHouseInstallations = InHouseInstallation::with('sale_contract', 'inhouseInstallationTeams', 'installationProgresses')
        ->latest()->paginate(10);

        return view('admin.inHouseInstallations.index', compact('inHouseInstallations'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('in_house_installation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id');

        $site_engineers = User::whereHas('roles', function($query) {
            $query->where('title', config('roles.siteEngineer'));            
        })
        ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approved_service_managers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approved_project_managers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.inHouseInstallations.create', compact(
            'servicing_teams', 
            'site_engineers', 
            'sale_contracts', 
            'approved_service_managers', 
            'approved_project_managers',
        ));
    }

    public function store(StoreInHouseInstallationRequest $request)
    {
        $userId = Auth::user()->id;
        $saleContract = SaleContract::findOrFail($request->sale_contract_id);

        $inHouseInstallation = InHouseInstallation::create($request->all());

        foreach($request->servicing_team_id as $id){
            InhouseInstallationTeam::create([
                'created_by_id' => $userId,
                'servicing_team_id' => $id,
                'inhouse_installation_id' => $inHouseInstallation->id
            ]);
        }

        /**
         * Create handover checklist
         */
        $handoverPdfTypes = config('pdfTypes.sale_contract.handover_pdfs');

        foreach($handoverPdfTypes as $key => $type){
            HandOverChecklist::create([
                'type' => $key,
                'in_house_installation_id' => $inHouseInstallation->id
            ]);
        }

        dispatch(new CompletingSaleContractEstimatedDateJob($saleContract));

        // if ($request->input('actual_installation_report_pdf', false)) {
        //     $inHouseInstallation->addMedia(storage_path('tmp/uploads/' . $request->input('actual_installation_report_pdf')))->toMediaCollection('actual_installation_report_pdf');
        // }

        return redirect()->route('admin.sale-contracts.show', [$saleContract]);
    }

    public function edit(InHouseInstallation $inHouseInstallation)
    {
        abort_if(Gate::denies('in_house_installation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inHouseInstallation->load('site_engineer', 'sale_contract', 'approved_service_manager', 'approved_project_manager', 'inhouseInstallationTeams');
        
        $service_teams = [];

        foreach($inHouseInstallation->inhouseInstallationTeams as $inhouseInstallationTeam) {
            array_push($service_teams, $inhouseInstallationTeam->servicing_team->id);
        }
        
        $site_engineers = User::whereHas('roles', function($query) {
            $query->where('title', config('roles.siteEngineer'));            
        })
        ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.inHouseInstallations.edit', compact('sale_contracts', 'servicing_teams', 'inHouseInstallation', 'site_engineers', 'service_teams'));
    }

    public function update(UpdateInHouseInstallationRequest $request, InHouseInstallation $inHouseInstallation)
    {
        $inHouseInstallation->update($request->all());

        $userId = Auth::user()->id;
    
        foreach($inHouseInstallation->inhouseInstallationTeams as $inhouseInstallationTeam) {
            $inhouseInstallationTeam->delete();
        }

        foreach($request->servicing_team_id as $id){
            InhouseInstallationTeam::create([
                'created_by_id' => $userId,
                'servicing_team_id' => $id,
                'inhouse_installation_id' => $inHouseInstallation->id
            ]);
        }
                
        return redirect()->route('admin.in-house-installations.show', $inHouseInstallation);
    }

    public function show(InHouseInstallation $inHouseInstallation)
    {
        abort_if(Gate::denies('in_house_installation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inHouseInstallation->load('site_engineer', 'sale_contract', 'approved_service_manager', 'approved_project_manager');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $saleContract = $inHouseInstallation->sale_contract;

        $otherDocuments = $saleContract->saleContractPdfs()->otherDocs()->get();

        return view('admin.inHouseInstallations.show', compact('inHouseInstallation', 'servicing_teams', 'saleContract', 'otherDocuments'));
    }

    public function destroy(InHouseInstallation $inHouseInstallation)
    {
        abort_if(Gate::denies('in_house_installation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inHouseInstallation->delete();

        return back();
    }

    public function massDestroy(MassDestroyInHouseInstallationRequest $request)
    {
        InHouseInstallation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function viewDocs(SaleContract $saleContract, InHouseInstallation $inHouseInstallation)
    {
        abort_if(Gate::denies('upload_other_docs_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $saleContract->load('saleContractPdfs', 'inHouseInstallation');

        $otherDocuments = $saleContract->saleContractPdfs()->otherDocs()->get();
        
        return view('admin.inHouseInstallations.docs', compact('saleContract', 'inHouseInstallation', 'otherDocuments'));
    }

    public function currentProjects()
    {
        $inHouseInstallations = InHouseInstallation::where('status', 'Ongoing')->latest()->paginate(10);

        return view('admin.inHouseInstallations.ongoingProjects', compact('inHouseInstallations'));
    }
}
