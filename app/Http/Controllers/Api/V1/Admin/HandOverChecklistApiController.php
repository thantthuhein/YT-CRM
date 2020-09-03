<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\HandOverChecklist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HandOverChecklistApiController extends Controller
{
    public function toggleNecessary(HandOverChecklist $handOverChecklist){
        $handOverChecklist->is_necessary = !$handOverChecklist->is_necessary;
        $handOverChecklist->update();

        return $handOverChecklist;
    }
}
