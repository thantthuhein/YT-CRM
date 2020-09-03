<?php

namespace App\Http\Controllers\Admin;

use App\ReminderType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReminderTypeRequest;
use App\Role;
use Illuminate\Support\Facades\Route;

class ReminderTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reminderTypes = ReminderType::paginate(10);

        return view('admin.reminderTypes.index', compact('reminderTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(collect(Route::getRoutes())->map(function($route){ dd($route);}));
        $roles = Role::all()->pluck('title', 'id');
        return view('admin.reminderTypes.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReminderTypeRequest $request)
    {
        $reminderType = ReminderType::create($request->validated());

        if($request->has('role_id'))
        {
            $reminderType->whoToRemind()->attach($request->role_id ?? []);
        }

        return redirect()->route('admin.reminder-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function show(ReminderType $reminderType)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function edit(ReminderType $reminderType)
    {
        $roles = Role::all()->pluck('title', 'id');
        return view('admin.reminderTypes.edit', compact('roles', 'reminderType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReminderTypeRequest $request, ReminderType $reminderType)
    {
        $reminderType->update($request->validated());
        
        $reminderType->whoToRemind()->sync($request->role_id ?? []);

        return redirect()->route('admin.reminder-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReminderType  $reminderType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReminderType $reminderType)
    {
        //
    }
}
