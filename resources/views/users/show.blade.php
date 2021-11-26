@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{$owner->surname}} {{$owner->names}}
                <span class="btn btn-primary pull-right">Change Address</span>
                </div>

                <div class="card-body">
                    <p><b> National Id</b> {{$owner->national_id}}</p>
                    <p><b> Phone No.</b> {{$owner->phone_no}}</p>
                   <p> <b> Registered By</b> {{$owner->national_id}}</p>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection