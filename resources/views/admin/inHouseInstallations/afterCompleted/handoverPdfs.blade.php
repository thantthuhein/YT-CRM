{{-- <input type="hidden" id="handover_pdfs" name="handover_pdfs"> --}}
<div>
    @if(session('success'))
        <div class="alert alert-success mt-3">
            <ul class="list-unstyled">
                <li class="list-item">{{session('success')}}</li>
            </ul>
        </div>
    @endif
</div>

<div class="card my-3">
    <h4 class="card-header">
        Upload Handover Files
    </h4>

    <div class="card-body">
        @foreach($handoverPdfs as $key => $pdf)
            @php
                $checklist = $checklists->count() > 0 ? $checklists[$key]->first() : null;
                $uploaded = $checklist && $checklist->uploaded_at != null;
                $necessary = $checklist && $checklist->is_necessary;
            @endphp
            <div class="form-group ml-3">
                @if($checklists->count() > 0 )
                    @if($uploaded)
                        <span class="{{ $key }}"><i class="far fa-check-square"></i></span>
                    @else
                        <span class="{{ $key }}"><i class="far fa-square"></i></span>
                    @endif

                    @if(!$uploaded)
                        @if($necessary)
                            <label for="" class="form-check-label label_{{ $key }}">{{ $pdf }}</label>
                            <div class='toggle_{{$key}} ml-4' style="display: inline-block;">
                                <button type="button" class='btn btn-sm btn-danger' 
                                data-type="{{ $key }}" 
                                data-id="{{ $checklist->id ?? '' }}"
                                onclick="makeUnnecessary(this)">Make Unnecessary</button>
                            </div>
                        @else
                            <label for="" class="form-check-label label_{{ $key }} strike">{{ $pdf }}</label>
                            <div class='toggle_{{$key}} ml-4' style="display: inline-block;">
                                <button type="button" class='btn btn-sm btn-success' 
                                data-type="{{ $key }}" 
                                data-id="{{ $checklist->id ?? '' }}"
                                onclick="makeNecessary(this)">Make Necessary</button>
                            </div>
                        @endif
                    @else
                        <label for="" class="form-check-label label_{{ $key }}">{{ $pdf }}</label>
                    @endif
                @else
                    <span class="{{ $key }}"><i class="far fa-square"></i></span>
                    <label for="" class="form-check-label label_{{ $key }}">{{ $pdf }}</label>
                    <div class='toggle_{{$key}} ml-4' style="display: inline-block;">
                        <button type="button" class='btn btn-sm btn-danger' 
                            data-type="{{ $key }}" 
                            data-id="{{ $checklist->id ?? '' }}"
                            onclick="makeUnnecessary(this)">Make Unnecessary</button>
                    </div>        
                @endif
            </div>
        @endforeach

        <!-- this code is for temporary -->
        @foreach($handoverPdfs as $key => $pdf)
            {{-- @php
                $checklist = $checklists->count() > 0 ? $checklists[$key]->first() : null;
                $uploaded = $checklist && $checklist->uploaded_at != null;
            @endphp
            @if($key == 'test_report' || !$uploaded) --}}
                <div class="form-group" id="input_wrapper_{{ $key }}">
                    <label for="">{{ $pdf }}{{ $key == 'test_report' ? ' (Multiple)' : ''}}</label>
                    <input type="file" id="{{$key}}" 
                            data-type="{{ $key }}"
                            name='{{ $key == 'test_report' ? 'handover_pdfs['.$key.'][]' : 'handover_pdfs['.$key.']' }}' 
                            {{ $key == 'test_report' ? 'multiple' : ''}} 
                            class='form-control' accept="application/pdf">
                </div>
            {{-- @endif --}}
        @endforeach
    </div>
</div>

@push('js')
<script>
    function makeUnnecessary(ele){
        let type = ele.dataset.type;
        let id = ele.dataset.id;

        if(id == ""){
            alert('Something Wrong!');
        }
        else{
            $(`.toggle_${type}`).html(`<button type="button" class='btn btn-sm btn-success' 
                                                    data-type="${type}" 
                                                    data-id="${id}"
                                                    onclick="makeNecessary(this)">
                                                    Make necessary
                                        </button>`);
            $(`#input_wrapper_${type}`).css({
                display: "none"
            });

            $(`.label_${type}`).addClass('strike');

            toggleChecklistNecesscary(id);
        }

    }

    function makeNecessary(ele){
        let type = ele.dataset.type;
        let id = ele.dataset.id;

        if(id == ""){
            alert('Something Wrong!');
        }
        else{        
            $(`.label_${type}`).removeClass('strike');

            $(`.toggle_${type}`).html(`<button type="button" class='btn btn-sm btn-danger' 
                                                    data-type="${type}" 
                                                    data-id="${id}"
                                                    onclick="makeUnnecessary(this)">
                                                    Make Unnecessary
                                            </button>`);
            $(`#input_wrapper_${type}`).css({
                display: "block"
            });

            toggleChecklistNecesscary(id);

        }
    }

    function toggleChecklistNecesscary(id){
        let url = `/api/v1/hand-over-checklist/${id}/toggle-necessary`;
        fetch(url, {
            "method" : "POST",
            "headers": {
                'Content' : 'application/json',
                'Accept' : 'application/json'
            },
        })
        .then((data) => data.json())
    }
</script>
@endpush