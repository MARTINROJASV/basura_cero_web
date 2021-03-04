@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/tickets_caborcas') }}">TICKETS CABORCA</a> :
@endsection
@section("contentheader_description", $tickets_caborca->$view_col)
@section("section", "TICKETS CABORCAS")
@section("section_url", url(config('laraadmin.adminRoute') . '/tickets_caborcas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "TICKETS CABORCAS Edit : ".$tickets_caborca->$view_col)

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
				{!! Form::model($tickets_caborca, ['route' => [config('laraadmin.adminRoute') . '.tickets_caborcas.update', $tickets_caborca->id ], 'method'=>'PUT', 'id' => 'tickets_caborca-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'correoinstitucional')
					@la_input($module, 'foto')
					@la_input($module, 'validado')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/tickets_caborcas') }}">Cancel</a></button>
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
	$("#tickets_caborca-edit-form").validate({
		
	});
});
</script>
@endpush
