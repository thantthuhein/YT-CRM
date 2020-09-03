@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.handOverPdf.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hand-over-pdfs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.id') }}
                        </th>
                        <td>
                            {{ $handOverPdf->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.inhouse_installation') }}
                        </th>
                        <td>
                            {{ $handOverPdf->inhouse_installation->estimate_start_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.url') }}
                        </th>
                        <td>
                            @if($handOverPdf->url)
                                <a href="{{ $handOverPdf->url->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.file_type') }}
                        </th>
                        <td>
                            {{ App\HandOverPdf::FILE_TYPE_SELECT[$handOverPdf->file_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.handOverPdf.fields.description') }}
                        </th>
                        <td>
                            {!! $handOverPdf->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.hand-over-pdfs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection