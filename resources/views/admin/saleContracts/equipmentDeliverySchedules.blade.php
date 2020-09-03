@if ($saleContract->equipmentDeliverySchedules)        
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.sale-contracts.createEquipmentDeliverySchedule', [$saleContract]) }}" 
            class="btn btn-sm btn-save"><i class="fas fa-plus-circle"></i> &nbsp;Add New</a>
        </div>
        
        <div class="card-body p-0">
            @if ($saleContract->equipmentDeliverySchedules->isEmpty())
                No Records Yet
            @else                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Delivered On</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saleContract->equipmentDeliverySchedules as $equipmentDeliverySchedule)                    
                        <tr>
                            <td>{{ $equipmentDeliverySchedule->description ?? '' }}</td>
                            <td>{{ $equipmentDeliverySchedule->delivered_at->format('d-D-M-Y') ?? '' }}</td>
                            <td>
                                <a href="{{ route('admin.equipment-delivery-schedules.edit', $equipmentDeliverySchedule) }}" 
                                class="btn btn-default rounded-pill">
                                    <i class="fas fa-edit"></i>&nbsp;Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endif