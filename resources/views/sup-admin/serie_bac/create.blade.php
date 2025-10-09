@extends('sup-admin.layouts.master')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Ajouter une série</h4>
                        <a href="{{route('sup-admin.serie_bac.index')}}" class="btn btn-primary">Liste des séries du Bac</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('sup-admin.serie_bac.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nom">Nom complet</label>
                                        <input type="text" name="nom" value="{{ old('nom') }}" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}" id="nom">
                                        @if($errors->has('nom'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('nom') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
