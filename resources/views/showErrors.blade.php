<div style="margin: 0 30px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                {!! implode('', $errors->all('<li class="error list-item">:message</li>')) !!}
            </ul>
        </div>
    @endif
</div>