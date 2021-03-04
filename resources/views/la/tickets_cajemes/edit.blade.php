@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/tickets_cajemes') }}">TICKETS CAJEME</a> :
@endsection
@section("contentheader_description", $tickets_cajeme->$view_col)
@section("section", "TICKETS CAJEMES")
@section("section_url", url(config('laraadmin.adminRoute') . '/tickets_cajemes'))
@section("sub_section", "Edit")

@section("htmlheader_title", "TICKETS CAJEMES Edit : ".$tickets_cajeme->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($tickets_cajeme, ['route' => [config('laraadmin.adminRoute') . '.tickets_cajemes.update', $tickets_cajeme->id ], 'method'=>'PUT', 'id' => 'tickets_cajeme-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'correoinstitucional')
					@la_input($module, 'foto')
					@la_input($module, 'validado')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/tickets_cajemes') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#tickets_cajeme-edit-form").validate({
		
	});
});
</script>
@endpush
