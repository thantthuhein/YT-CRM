<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\Company;
use App\Project;
use App\Enquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\Admin\CompanyResource;
use Symfony\Component\HttpFoundation\Response;

class CompanyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CompanyResource(Company::all());
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->all());

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Company $company)
    {
        abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CompanyResource($company);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->all());

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Company $company)
    {
        abort_if(Gate::denies('company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function searchCompany(Request $request){
        $name= $request->name;
        $companies = Company::search($name ?? "")->get();
        return $companies;
    }

    public function checkCompanyAndProject(Request $request)
    {
        $id = $request->id ?? 0;

        $company = Company::where('name', $request->company_name)->first();
        $project = Project::where('name', $request->project_name)->first();

        if($company && $project){
            $enquiry = Enquiry::where([
                ['company_id', '=', $company->id],
                ['project_id', '=', $project->id],
                ['status', '=', 'active'],
            ])->first();
        }
        
        if (isset($enquiry) && $enquiry->id != $id) {
            return response()->json(['match'=> true, 'message' => 'Company And Project already existed', 'data' => $enquiry], 200);
        } else {
            return response()->json(['match'=> false, 'message' => 'Not Found'], 200);
        }
    }
}
