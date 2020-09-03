@extends('layouts.admin')

@section('content')
<div class="card content-card">
    <div class="card-header">
        Create New Note For {{ $customer->name }}        
    </div>

    <div class="card-body">
        <form action="{{ route('admin.customers.storeNote', [$customer]) }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
    
                <label for="notes">Note</label>
        
                <textarea name="notes" id="notes" cols="30" rows="5" 
                class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}"
                ></textarea>
                @if ($errors->has('notes'))                    
                <small class="text-danger">{{ $errors->first('notes') }}</small>
                @endif
    
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-save">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection