@extends('layouts.app')

@section('content')
    @foreach($sections as $section)
        @includeIf('sections.' . $section->type, ['section' => $section])
    @endforeach
@endsection