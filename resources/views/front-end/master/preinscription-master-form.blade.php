@extends('front-end.layouts.master')
@section('content')
    <style>
        #app{
            margin-top: 3%;
        }
        

    </style>
    <div id="app">
        <Formstepsmaster 
            :appurl="'{{ config('app.url') }}'"
            :cne="{{ json_encode($cne) }}" 
            :cin="{{ json_encode($cin) }}" 
            :etablissement="{{ json_encode($etablissement) }}"
            :filieres="{{ json_encode($filieres) }}"
        />
    </div>
@endsection

