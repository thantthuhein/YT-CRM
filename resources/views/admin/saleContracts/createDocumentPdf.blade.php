@extends('layouts.admin')

@section('content')

<div class="card content-card">
    <div class="card-header">
        Add Document PDF
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
        <form action="{{ route('admin.sale-contracts.storeDocumentPdf', [$saleContract]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="multiple-pdfs-container">
                @if (old('text') && old('file'))                   
                    @php
                        $text = collect(old('text'));                    
                        $file = collect(old('file'));                   
                        $combined = $text->combine($file);
                    @endphp
                    
                    @foreach ($combined as $text => $file)
                        <div class="schedule-wrapper">
                            <div class="form-group mr-2">
                                <label for="text">Text</label>
                                <input type="text" class="form-control" name="text[{{\Carbon\Carbon::now()}}]" value="{{$text}}">
                            </div>
                            
                            <div class="form-group">
                                <label for="file">PDF</label>
                                <input type="date" class="form-control" name="file[{{\Carbon\Carbon::now()}}]" value="{{$file}}">
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

            <div class="form-group">
                <button type="submit" class="btn btn-save">Save</button>
            </div>
        </form>
    </div>

</div>

@endsection

@section('scripts')
    <script>
        let addMoreBtn = document.getElementById('add-more-pdf');
        let pdfsContainer = document.getElementById('multiple-pdfs-container');

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
                                        <input type="text" name="text[${id}]" class='form-control pdf-text' data-id="pdf-${id}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pdf">Upload PDF</label>
                                        <input type="file" name="file[${id}]" class="form-control pdf-file" data-id="pdf-${id}" accept="application/pdf" required>
                                    </div>
                                    <span class="schedule-close" onclick="this.parentNode.remove()"><i class="fas fa-times"></i></span>
                                </div>`;
            return tmpDiv.childNodes;
        }
    </script>
@endsection