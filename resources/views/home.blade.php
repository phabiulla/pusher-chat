@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <users-group :user="{{ $user }}" :initial-users="{{ $users }}"></users-group>
        </div>
        <div class="col-sm-8">
            <groups :user="{{ $user }}"></groups>
        </div>
    </div>
</div>
@endsection
