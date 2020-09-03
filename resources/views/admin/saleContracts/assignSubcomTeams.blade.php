@extends('layouts.admin')
@section('content')
@include('showErrors')
<div class="content-card card display-card text-white">
    <div class="card-header">
        Assign Sub Com Teams
    </div>

    <div class="card-body">

        @include('admin.saleContracts.infoTable')

        <div class="work-lists" id="work-lists">
            
        </div>
        <div class="assign-team-list">
            <div class="assign-team">
                {{-- <form action='' method="GET"> --}}
                    <select class='form-control' id="subcom" name="subcom">
                        @foreach($subCompanies as $key => $subCompany)
                            <option value="{{ $key }}" {{ $key == request()->subcom ? 'selected' : ""}} data-name="{{ $subCompany }}">{{ $subCompany }}</option>
                        @endforeach
                    </select>
                    <span id='subcom-error' class="text-danger"></span>
                {{-- </form> --}}
            </div>
            <div class="assign-team">
                <select class='form-control' id="installationType">
                    @foreach($installationTypes as $installationType)
                        <option value="{{ $installationType }}">{{ $installationType }}</option>
                    @endforeach
                </select>
                <span id='installation-type-error' class="text-danger"></span>
            </div>
            {{-- <div class="assign-team">
                <input type='number' class='form-control' min=1 max=12 name="month" id="month" placeholder="Month">
                <span id='month-error' class="text-danger"></span>
            </div>
            <div class="assign-team">
                <input type='number' class='form-control' step="1" name="year" id="year" placeholder="Year">
                <span id='year-error' class="text-danger"></span>
            </div>
            <div class="assign-team">
                <input type='number' class='form-control' step="1" max="5" name="rating" id="rating" placeholder="Place Rating">
                <span id='rating-error' class="text-danger"></span>
            </div> --}}
            <div class="assign-team">
                <button class='btn btn-create' id="add-works"><i class="fas fa-plus py-1"></i></button>
            </div>
            <div class="assign-team">
                <form action="{{ route('admin.sale-contracts.assign-subcom-teams', [$saleContract]) }}" method="POST">
                    @csrf
                    <input type="hidden" id="works-hidden" name="works" value="">
                    <button type="submit" class='btn btn-create'>Assign</button>
                </form>
            </div>
        </div>

        <div class="form-group mt-3">            
            <a class="btn btn-create" href="{{ route('admin.sale-contracts.show', [$saleContract]) }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        let works = [];
        let subcom = document.getElementById('subcom');
        let work = document.getElementById('installationType');
        // let monthEle = document.getElementById('month');
        // let yearEle = document.getElementById('year');
        // let ratingEle = document.getElementById('rating');

        $('#add-works').on('click', addWorks);

        function addWorks(){

            let id = Date.now();

            if(subcom.value == ""){
                $('#subcom-error').html('Please choose subcom!');
                return;
            }
            else{
                $('#subcom-error').html("");
            }

            if(work.value == ""){
                $('#installation-type-error').html('Please choose installtion type!');
                return;
            }
            else{
                $('#installation-type-error').html("");
            }

            // if(monthEle.value == ""){
            //     $('#month-error').html('Please enter month!');
            //     return;
            // }
            // else{
            //     $('#month-error').html("");
            // }
            // if(yearEle.value == ""){
            //     $('#year-error').html('Please enter year!');
            //     return;
            // }
            // else{
            //     $('#year-error').html("");
            // }

            
            works.push({
                id : id,
                subcom : subcom.value,
                name : subcom.options[subcom.selectedIndex].dataset.name,
                work : work.value,
                // month : monthEle.value == "" ? null : monthEle.value,
                // year : yearEle.value == "" ? null : yearEle.value,
                // rating : ratingEle.value == "" ? null : ratingEle.value,
            });

            console.log(works);

            attachEleToNode(works);
        }

        let addedWorks = document.querySelectorAll('#work-lists .remove-work');

        addedWorks.forEach((removeNode) => {
            removeNode.addEventListener('click', function(evt){
                id = evt.target.dataset.id;
                works = works.filter((work) => {
                    return work.id != id;
                })
                attachEleToNode(works);
            })
        });

        this.removeWork = function(id){
            works = works.filter(function(item) {
                return item.id != id
            })
            // console.log(works)
            attachEleToNode(works)
        }

        function attachEleToNode(works){
            let workListsEle = "";
            works.forEach((work) => {
                workListsEle +=`<div class="work-list-item">
                                    <label>${work.name} (${work.work})</label>
                                    <span class="remove-work px-3" 
                                            data-id="${work.id}" id="${work.id}" 
                                            onclick="removeWork(${work.id})"
                                            style="cursor:pointer">
                                        x
                                    </span>
                                </div>`

            })

            $(".work-lists").html(workListsEle);

            $('#works-hidden').val(JSON.stringify(works));

        }
    });
</script>