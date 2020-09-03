@extends('layouts.admin')
@section('content')

<div style="margin:0 30px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
    @endif
</div>

<div class="card content-card" style="height: auto">
    
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.saleContract.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="required">{{ trans('cruds.saleContract.fields.has_installation') }}</label>
                <div class="row ml-1">
                    @foreach(App\SaleContract::HAS_INSTALLATION_RADIO as $key => $label)
                        <div class="ml-2 form-check {{ $errors->has('has_installation') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="has_installation_{{ $key }}" name="has_installation" value="{{ $key }}" {{ old('has_installation', $hasInstallation == 'Yes' ? '1' : '0') === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label lowercase" for="has_installation_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
                @if($errors->has('has_installation'))
                    <span class="text-danger">{{ $errors->first('has_installation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.has_installation_helper') }}</span>
            </div>

            <div class="form-group" id="installation-type-div" {{old('has_installation', ($hasInstallation == 'Yes' ? '1' : '0')) == '1' ? "style=display:block;" : 'style=display:none;'}}>
                <label>{{ trans('cruds.saleContract.fields.installation_type') }}</label>
                <select class="form-control {{ $errors->has('installation_type') ? 'is-invalid' : '' }}" name="installation_type" id="installation_type">
                    <option value disabled {{ old('installation_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\SaleContract::INSTALLATION_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('installation_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('installation_type'))
                    <span class="text-danger">{{ $errors->first('installation_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.installation_type_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="payment_terms">{{ trans('cruds.saleContract.fields.payment_terms') }}</label>
                <input class="form-control {{ $errors->has('payment_terms') ? 'is-invalid' : '' }}" type="number" name="payment_terms" id="payment_terms" value="{{ old('payment_terms') }}" min=1 max=8 step="1">
                @if($errors->has('payment_terms'))
                    <span class="text-danger">{{ $errors->first('payment_terms') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saleContract.fields.payment_terms_helper') }}</span>
            </div>


            <div class="card" style="margin-bottom: 10px !important;">
                <h5 class='card-header'>Equipment Delivery Schedule</h5>
                <div class='card-body'>
                    <div class="form-group" id="equipment_delivery_schedule_section">
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
                </div>
            </div>               
            
            <div class='card' style="margin-bottom: 10px !important;">
                <h5 class='card-header'>Document PDFs</h5>
                
                <div class='card-body'>
                    @if (old('text') && old('file'))
                        <p>Exists</p>
                        
                    @endif
                    <div id="multiple-pdfs-container">
                        @if (old('text'))                                                                           
                            @foreach (old('text') as $text)
                            <div class="pdf-upload-wrapper">
                                <div class="form-group">
                                    <label for="pdf_title">Enter title</label>
                                    <input type="text" name="text[{{\Carbon\Carbon::now()}}]" class='form-control pdf-text' value="{{ $text }}">
                                </div>
                                <div class="form-group">
                                    <label for="pdf">Upload PDF</label>
                                    <input type="file" name="file[{{\Carbon\Carbon::now()}}]" class="form-control pdf-file" accept="application/pdf" value="">
                                </div>
                                <span class="schedule-close" onclick="this.parentNode.remove()"><i class="fas fa-times"></i></span>
                            </div>
                            @endforeach

                        @endif
                    </div>
                    <div class="add-more" id="add-more-pdf">
                        <div class="icon">
                            +
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                @if($hasInstallation == 'Yes')
                    <button class="btn btn-save" type="submit" id="save-btn">
                        Next
                    </button>
                @else
                    <button class="btn btn-save" type="submit" id="save-btn">
                        Save
                    </button>
                @endif                                

            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
    <script>
        let saveBtn = document.getElementById('save-btn');
        let addMoreBtn = document.getElementById('add-more-pdf');
        let installationTypeDiv = document.getElementById('installation-type-div');
        let pdfsContainer = document.getElementById('multiple-pdfs-container');
        let hasInstallationRadios = document.querySelectorAll('input[type=radio]');

        let addMoreScheduleBtn = document.getElementById('add-more-delivery-schedule');
        let scheduleSection = document.getElementById('equipment_delivery_schedule_section');

        hasInstallationRadios.forEach(function(radio){
            radio.addEventListener('change', function(){
                let hasInstallation = Boolean(parseInt(this.value));
                // let hasInstallation = String(this.value);
                if(hasInstallation){
                    saveBtn.innerHTML = "Next";
                    installationTypeDiv.style.display = "block";
                }
                else{
                    saveBtn.innerHTML = "Save";
                    installationTypeDiv.style.display = "none";

                }
            })
        })

        addMoreBtn.addEventListener('click', function(evt){
            let newId = Date.now();
            let childNodes = toDom(newId);
            
            for (var i = 0; i < childNodes.length; i++) {
                pdfsContainer.appendChild(childNodes[i])   
            }

        })

        function toDom(id){
            let tmpDiv = document.createElement('div');
            tmpDiv.innerHTML = `<div class="pdf-upload-wrapper" id="pdf-wrapper-${id}">
                                    <div class="form-group">
                                        <label for="pdf_title">Enter title</label>
                                        <input type="text" name="text[${id}]" class='form-control pdf-text' data-id="pdf-${id}" value="{{ old('text[${id}]', '') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pdf">Upload PDF</label>
                                        <input type=file name="file[${id}]" class="form-control pdf-file" data-id="pdf-${id}" accept="application/pdf" value="{{ old('file[${id}]', '') }}" required>
                                    </div>
                                    <span class="schedule-close" onclick="this.parentNode.remove()"><i class="fas fa-times"></i></span>
                                </div>`;
            return tmpDiv.childNodes;
        }

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
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" name="description[${id}]" value="{{ old('description[${id}]') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="delivered_at">Delivered At</label>
                                        <input type="date" class="form-control" name="delivered_at[${id}]" value="{{ old('delivered_at[${id}]') }}">
                                    </div>
                                    <span class="schedule-close" onclick="this.parentNode.remove()"><i class="fas fa-times"></i></span>
                                </div>`;
            return tmpDiv.childNodes;
        }
        // let pdfArray = {};

        // function textChange(ele){
        //     let eleId = ele.dataset.id;
            
        //     pdfArray[eleId]["title"] = ele.value;

        //     setToHiddenValue();
        // }

        // function fileChange(ele){
        //     let eleId = ele.dataset.id;
            
        //     pdfArray[eleId]["pdf"] = ele.files[0];
        //     let fileReader = new FileReader();
        //     fileReader.onload = function(event){
                
        //     }
        //     fileReader.readAsDataURL(ele.files[0]);
        //     console.log('pdfArray: ', pdfArray);

        //     setToHiddenValue();
        // }

        // function setToHiddenValue(){
        //     document.getElementById('pdfs').value = JSON.stringify(pdfArray);
        // }
    </script>
@endsection