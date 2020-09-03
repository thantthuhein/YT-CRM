{{-- @can('payment_steps_access',)    
@endcan --}}
<div class="card text-dark">
    <div class="d-flex my-2">
        <p class="font-weight-bold">Payment Steps</p>
        @if ($saleContract->checkPaymentTerms())            
            <div class="ml-auto">
                <a href="{{ route('admin.sale-contracts.editPaymentTerms', [$saleContract]) }}" class="btn btn-sm btn-save"><i class="fas fa-edit"></i> Edit Payment Terms</a>
            </div>
        @endif
    </div>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">

            @foreach ($paymentSteps as $paymentStep)
                <a 
                @if (session('payment_step_id'))
                class="nav-item nav-link text-dark {{ $paymentStep->id == session('payment_step_id')  ? 'active' : '' }}"     
                @else
                class="nav-item nav-link text-dark {{ $paymentStep->title == "First Payment" ? 'active' : '' }}" 
                @endif
                id="{{ $paymentStep->id }}" 
                data-toggle="tab" 
                href="#{{ str_replace(' ', '_', $paymentStep->title) }}" 
                role="tab" 
                aria-selected="true"
                >

                    {{ $paymentStep->title }}
                    &nbsp;
                    @if (NULL !== $paymentStep->completed_at)                        
                        <i class="fas fa-check-circle text-success"></i>
                    @endif

                </a>


            @endforeach
            
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">

        @foreach ($paymentSteps as $paymentStep)
            
        <div 
        @if (session('payment_step_id'))
        class="tab-pane fade {{ $paymentStep->id == session('payment_step_id') ? 'active show' : '' }}"     
        @else
        class="tab-pane fade {{ $paymentStep->title == "First Payment" ? 'active show' : '' }}" 
        @endif
        id="{{ str_replace(' ', '_', $paymentStep->title) }}" 
        role="tabpanel" 
        aria-labelledby="{{ $paymentStep->id }}"
        >

            <div class="container">
                <div class="row">
                    <div class="col p-0">
                        @if (NULL !== $paymentStep->completed_at)
                        <div class="alert alert-success m-0" role="alert">
                            <p class="text-light font-weight-bold font-italic p-0 m-0">
                                Payment Completed At - {{ $paymentStep->completed_at }} &nbsp;<i class="far fa-check-circle"></i>
                            </p>
                        </div>
                        @endif
                        
                        @if ( session('no_invoices_error') )
                            <div class="alert alert-danger" role="alert">
                                <p class="text-light font-weight-bold font-italic p-0 m-0">
                                    {{ session()->get('no_invoices_error') }}
                                </p>
                            </div>
                        @endif
                        
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="mr-3">
                                        <p class="font-weight-bold mt-2">{{ $paymentStep->title }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.sale-contracts.paymentSteps.editTitle', [$saleContract, $paymentStep]) }}" class="btn btn-default">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    
                                    <div class="ml-auto">
                                        @if (  $paymentStep->completed_at == NULL )
                                        <form action="{{ route('admin.sale-contracts.paymentSteps.complete') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="payment_step_id" value="{{ $paymentStep->id }}">

                                            <button {{ $paymentStep->invoices->isEmpty() ? 'disabled' : ''}} type="submit" class="btn btn-sm btn-success rounded-pill">
                                                Complete Payment Step
                                            </button>
                                        </form>
                                        @else 
                                        <div class="d-flex">
                                            <form action="{{ route('admin.sale-contracts.paymentSteps.unComplete') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="payment_step_id" value="{{ $paymentStep->id }}">

                                                <button type="submit" class="btn btn-sm btn-dark rounded-pill">
                                                    <i class="fas fa-undo-alt"></i> &nbsp;Uncomplete
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="card-body">

                                <p class="font-weight-bold">Invoice List</p>

                                <div class="container">
                                    <div class="row">
                                        @if ( $paymentStep->invoices->isEmpty() )
                                        <p>No Invoices</p>
                                        @else

                                        <div class="col-12 pl-0">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="font-weight-bold">Title</td>
                                                        <td class="font-weight-bold">Description</td>
                                                        <td class="font-weight-bold">View PDF</td>
                                                        <td class="font-weight-bold">Invoice Number</td>
                                                        <td class="font-weight-bold">Uploaded At</td>
                                                    </tr>
                                                    @foreach ($paymentStep->invoices as $invoice)    
                                                    <tr>
                                                        <td>{{ $invoice->title }}</td>
                                                        <td>{{ $invoice->description }}</td>
                                                        <td>
                                                            <a href="{{ $invoice->invoice_pdf }}" class="btn btn-primary btn-sm rounded-pill" target="_blank">
                                                                <i class="fas fa-eye"></i>&nbsp; View
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-pill badge-primary py-1 px-2">
                                                                {{ $invoice->iteration }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $invoice->created_at }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        @endif
                                        
                                    </div>

                                    @if ($paymentStep->completed_at == NULL)    
                                    <div class="row">
                                        <div class="col-12 p-0">
                                            <hr>
                                            <p class="font-weight-bold">Create New Invoice</p>
                                            
                                            <form method="POST" action="{{ route("admin.sale-contracts.storeInvoice") }}" enctype="multipart/form-data" onsubmit="loadPaymentStepSpinner()">
                                                @csrf
                                            
                                                <div class="form-row">
                                                    <div class="col">

                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" rows="1" name="title" id="title" value="{{ old('title', '') }}"></input>
                                                            @if($errors->has('title'))
                                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                                            @endif
                                                            <span class="help-block">{{ trans('cruds.quotation.fields.customer_address_helper') }}</span>
                                                        </div>

                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="invoice_pdf">Upload PDF</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input accept="application/pdf" name="invoice_pdf" type="file" class="form-control">
                                                                    </input>
                                                                </div>
                                                            </div>
                                                            @if($errors->has('invoice_pdf'))
                                                                <span class="text-danger">
                                                                    {{ $errors->first('invoice_pdf') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" rows="1" name="description" id="description">{{ old('description', '') }}</textarea>
                                                            @if($errors->has('description'))
                                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                                            @endif
                                                            <span class="help-block">{{ trans('cruds.quotation.fields.customer_address_helper') }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <input type="hidden" name="payment_step_id" value="{{ $paymentStep->id }}">
                                                </div>

                                                <div class="form-group">
                                                    <button class="btn btn-save" type="submit" id="payment-step-upload-invoice">
                                                        {{ trans('global.save') }}
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                            </div>
                            
                            
                        </div>
                        
                        <div class="my-4">
                            <a class="btn btn-default" href="{{ route('admin.sale-contracts.show', $saleContract->id) }}">
                                <i class="fas fa-long-arrow-alt-left"></i> {{ trans('global.back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @endforeach

    </div>

</div>