<div class="card p-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Type
                        </th>
                        <th>
                            Uploaded by
                        </th>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($otherDocuments as $otherDoc)
                        <tr>
                            <td>
                                {{ $otherDoc->title }}
                            </td>
                            <td>
                                {{ $otherDoc->uploaded_by->name }}
                            </td>
                            <td>
                                <a href="{{ $otherDoc->url }}" class='btn btn-sm btn-primary rounded-pill' target="_blank">
                                    <i class="far fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>