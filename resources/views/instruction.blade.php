<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        @if (session('instruction'))
        	<div class="alert alert-info">
        	    <ul>
                    {{ session('instruction')}}
                </ul>
        	</div>
        @endif
    </div>
</div>