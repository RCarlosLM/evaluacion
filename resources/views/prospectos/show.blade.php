@extends('layouts.app')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page">
        <a href="/">
            Prospectos
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        {{$prospecto->nombre}}
    </li>
  </ol>
</nav>
@endsection
@section('content')

    <div class="container">
        <llamadas
            :prospecto="{{$prospecto}}">
        </llamadas>
    </div>

@endsection
