@extends('layouts.master')

@section('content')
    {{ Confide::makeSignupForm()->render(); }} 
@stop()