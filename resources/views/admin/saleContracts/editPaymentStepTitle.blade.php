@extends('layouts.admin')

@section('content')
    <div class="card content-card">
        <div class="card-header">
            <p>Edit Payment Step Title</p>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.sale-contracts.paymentSteps.updateTitle', [$paymentStep]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $paymentStep->title) }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-save">Update</button>
            </form>
        </div>
        
    </div>
@endsection

@section('scripts')

@endsection