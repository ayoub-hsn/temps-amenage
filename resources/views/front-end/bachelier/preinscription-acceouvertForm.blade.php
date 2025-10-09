@extends('front-end.layouts.master')
@section('content')
    <style>
        #app{
            margin-top: 3%;
        }
        

    </style>
    <div id="app">
        <Formstepsbacacceouvert 
            :appurl="'{{ config('app.url') }}'"
            :cin="{{ json_encode($CIN) }}" 
            :datenais="{{ json_encode($datenais) }}" 
            :etablissement="{{ json_encode($etablissement) }}"
            :filiere="{{ json_encode($filiere) }}"
        />
    </div>
@endsection

