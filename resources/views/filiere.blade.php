
@extends('master')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;800&display=swap" rel="stylesheet">
        
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-filiere.css') }}">
    
    <div class="filiere-container">
        @php
            $filieres = [
                ['abbreviation' => 'INFO', 'full_name' => 'Informatique'],
                ['abbreviation' => 'MATH', 'full_name' => 'Mathématiques'],
                ['abbreviation' => 'PHYS', 'full_name' => 'Physique'],
                ['abbreviation' => 'CHEM', 'full_name' => 'Chimie'],
                ['abbreviation' => 'BIO', 'full_name' => 'Biologie'],
            ];
    
            $icons = ['fa-laptop', 'fa-flask', 'fa-book', 'fa-microscope', 'fa-leaf'];
            shuffle($icons);
        @endphp
    
        @foreach($filieres as $index => $filiere)
            <div class="filiere-card">
                <div class="icon-wrapper">
                    <i class="fas {{ $icons[$index] }}"></i>
                </div>
                <h3>{{ $filiere['abbreviation'] }}</h3>
                <p>{{ $filiere['full_name'] }}</p>
                <a href="#" class="btn">Voir Description</a>
            </div>
        @endforeach
    </div>
    

    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js'></script>
@endsection

