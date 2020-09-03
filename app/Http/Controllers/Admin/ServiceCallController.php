<?php
namespace App\Http\Controllers\Admin;

use App\ServicingSetup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceCallController extends Controller
{
    public function index()
    {
        $servicingCalls = ServicingSetup::where('request_type', config('servicingSetup.request_type_oncall'))->latest()->paginate(10);

        return view('admin.serviceCalls.index', compact('servicingCalls'));

    }
}
