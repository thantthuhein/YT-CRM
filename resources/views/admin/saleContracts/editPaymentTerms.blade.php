@extends('layouts.admin')

@section('content')
    <div class="card content-card">
        <div class="card-header">
            Edit Payment Terms
        </div>

        <div class="card-body">            
            <form action="{{ route('admin.sale-contracts.updatePaymentTerms', [$saleContract]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="payment_terms">Payment Terms ( 1 - 8 )</label>
                    <input type="text" name="payment_terms" class="form-control" value="{{ old('payment_terms', $saleContract->payment_terms) }}">
                    @if ($errors->has('payment_terms'))
                        <span class="text-danger">{{ $errors->first('payment_terms') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection