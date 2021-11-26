@extends('layouts.app')
@section('content')
<div class="container">
	    <div class="row justify-content-center" style="overflow-y: scroll;">
	        <div class="col-md-11">	
                    @if (session('message'))
						<div class="alert alert-success" role="alert">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  {{ session('message') }}
						</div>  
                    @endif	
                <form>
                    <div class="form-group">
                        <input v-model="searchTerm" type="text" class="form-control" name="search" placeholder="Search by vehicle Make, Model, Reg No. Chasis no or Owner ID..." v-on:keyup="searchRole">                                    
                    </div>
                </form>                     	                	
	            <div class="card">
	                <div class="card-header border-radius-4">Vehicles ({{$vehicles->total()}})</div>

	                <div class="card-body">
	             @if($vehicles->count()> 0)
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Registration Date</th>
								<th>Reg No.</th>
								<th>Make</th>
								<th>Model</th>
								<th>Color</th>
								<th>Gross Weight (kg)</th>
								<th>Net Weight (kg)</th>
								<th>Encrypted Reg No.</th>
							</tr>
						</thead>
						<tbody>
							@foreach($vehicles as $vehicle)
							<tr>
								<th scope="row">{{$count++}}</th>
									<td>{{$vehicle->created_at->format('j M Y, H:i:s')}}</td>
									<td>{{$vehicle->registration_number}}</td>
									<td>{{$vehicle->make}}</td>
									<td>{{$vehicle->model}}</td>
									<td>{{$vehicle->color}}</td>
									<td>{{$vehicle->gross_mass}}</td>
									<td>{{$vehicle->net_mass}}</td>
									{{-- <td><a href="/owners/{{$vehicle->owner->slug}}">{{ucwords($vehicle->owner->surname)}} {{ucwords($vehicle->owner->names)}}</a>
										<br>
										{{ucwords($vehicle->owner->national_id)}}

									</td> --}}
									<td>{{$vehicle->encryption}} <a href="/vehicles/{{$vehicle->slug}}">Decrypted version</a></td>
							</tr>
						@endforeach

						{{ $vehicles->links() }}
						</tbody>
					</table>
					@else
						You have no vehicles yet in your system
				@endif
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection