@extends('layouts.admin')

@section('content')
<div class="card content-card">
    <div class="card-header">
        Add Equipment Delivery Schedule
    </div>

    <div>
        @if (!$errors->isEmpty())            
        <div class="alert alert-danger" role="alert">
            <ul class="list-unstyled">
                @if ($errors->any())                    
                    <li>{!! implode('', $errors->all('<li class="error">:message</li>')) !!}</li>
                @endif
            </ul>
        </div>
        @endif        
    </div>

    <div class='card-body'>        
        <form action="{{ route('admin.sale-contracts.storeEquipmentDeliverySchedule', [$saleContract]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="equipment_delivery_schedule_section">
                @if (old('description') && old('delivered_at'))                   
                    @php
                        $descriptions = collect(old('description'));                    
                        $delivered_at = collect(old('delivered_at'));                   
                        $combined = $descriptions->combine($delivered_at);
                    @endphp
                    
                    @foreach ($combined as $description => $delivered_at)
                        <div class="schedule-wrapper">
                            <div class="form-group mr-2">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" name="description[{{\Carbon\Carbon::now()}}]" value="{{$description}}">
                            </div>
                            
                            <div class="form-group">
                                <label for="delivered_at">Delivered At</label>
                                <input type="date" class="form-control" name="delivered_at[{{\Carbon\Carbon::now()}}]" value="{{$delivered_at}}">
                            </div>
                            <span class="schedule-close" onclick="this.parentNode.remove()"><i class="fas fa-times"></i></span>
                        </div>
                    @endforeach

                @endif
            </div>
            <div class="add-more" id="add-more-delivery-schedule">
                <div class="icon">
                    +
                </div>
            </div>
    
            <div class="form-group">
                <button type="submit" class="btn btn-save">Save</button>
            </div>
        </form>
    </div>

</div>

@endsection

@section('scripts')
    <script>

        let addMoreScheduleBtn = document.getElementById('add-more-delivery-schedule');
        let scheduleSection = document.getElementById('equipment_delivery_schedule_section');        

        addMoreScheduleBtn.addEventListener('click', function(){
            let newId = Date.now();
            let childNodes = toDomScheduleList(newId);
            
            for (var i = 0; i < childNodes.length; i++) {
                scheduleSection.appendChild(childNodes[i])   
            }
        })

        function toDomScheduleList(id){
            let tmpDiv = document.createElement('div');
            tmpDiv.innerHTML = `<div class="schedule-wrapper" id=${id}>
                                    <div class="form-group mr-2">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" name="description[${id}]" value="{{ old('description[${id}]') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="delivered_at">Delivered At</label>
                                        <input type="date" class="form-control date" name="delivered_at[${id}]" value="{{ old('delivered_at[${id}]') }}">
                                    </div>
                                    <span class="schedule-close" onclick="this.parentNode.remove()"><i class="fas fa-times"></i></span>
                                </div>`;
            return tmpDiv.childNodes;
        }

    </script>
@endsection