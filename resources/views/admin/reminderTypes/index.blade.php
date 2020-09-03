@extends('layouts.admin')
@section('content')


{{-- @can('reminder_type_create') --}}
    <div class="my-3" style="margin-left: 30px;">
        <a class="btn btn-create" href="{{ route('admin.reminder-types.create') }}">
            {{ trans('global.add') }} Reminder Type
        </a>
    </div>
{{-- @endcan --}}
<div class="card content-card display-card">
    <div class="card-header text-white">
        Reminder Types List
    </div>

    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table class="en-list table table-borderless table-striped scrollbar">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Description
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $order = order(request()->page ?? 1, $reminderTypes->perPage())
                    @endphp
                    @foreach($reminderTypes as $key => $reminderType)
                        <tr data-entry-id="{{ $reminderType->id }}">
                            <td>
                                {{ $order++ ?? '' }}
                            </td>
                            <td>
                                {{\App\ReminderType::TYPES[$reminderType->type] ?? ''}} <br> 
                            </td>
                            
                            <td>
                                {{ $reminderType->description ?? '' }}
                                {{-- {{ $reminderType->reminder_model ?? ''}} --}}
                                {{-- {{ $reminderType->action ?? "" }} --}}
                            </td> 
                            <td>
                                <div class="d-flex">
                                    @can('reminder_type_show')
                                        <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.reminder-types.show', $reminderType->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    <a class="btn btn-sm btn-create mr-2" href="{{ route('admin.reminder-types.edit', $reminderType->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                </div>    
                            </td>                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $reminderTypes->appends(array_filter(request()->except('page')))->links()}}
        </div>


    </div>
</div>
@endsection