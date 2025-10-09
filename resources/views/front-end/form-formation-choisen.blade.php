@extends('front-end.layouts.master')
@section('content')
    <style>
        #app{
            margin-top: 3%;
        }
    </style>
    <!-- Section d'accueil avant le formulaire -->
    <section style="background: linear-gradient(to right, #004B87, #0066b3); color: white; padding: 60px 20px;">
        <div style="max-width: 1100px; margin: auto; text-align: center;">
            <h2 style="font-size: 2.5em; font-weight: bold; margin-bottom: 20px;">
                🎓 Bienvenue à l’Université Hassan 1er
            </h2>
            <p style="font-size: 1.2em; margin-bottom: 40px; line-height: 1.6;">
                Rejoignez une université moderne qui allie excellence académique, innovation et ouverture sur le monde.
                Nos programmes sont conçus pour vous préparer à un avenir brillant et plein d’opportunités.
            </p>
        </div>
    </section>

    <div id="app">
        <Formfilierechoisen
            :appurl="'{{ config('app.url') }}'"
            :filiere="{{ json_encode($filiere) }}"
        />
    </div>
@endsection

