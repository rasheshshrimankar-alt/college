@extends('layouts.dashboard')
@section('title','Mark Attendance')
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
@include('faculty.attendance.mark')
@endsection
