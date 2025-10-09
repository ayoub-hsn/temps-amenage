@extends('sup-admin.layouts.master')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Créer un etablissement</h4>
                        <a href="{{route('sup-admin.user.index')}}" class="btn btn-primary">Liste des utilisateurs</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('sup-admin.user.store')}}" method="post">
                            @csrf
                            <div class="row">
                                
                                
                               
                                <button class="btn btn-primary btn-block">Créer</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
