@extends('sup-admin.layouts.master')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Créer la province</h4>
                        <a href="{{route('sup-admin.province.index')}}" class="btn btn-primary">Liste des provinces</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('sup-admin.province.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nom">Nom de la Province</label>
                                        <input type="text" name="nom" value="{{ old('nom') }}" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}" id="nom">
                                        @if($errors->has('nom'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('nom') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                               
                              
                                <button class="btn btn-primary btn-block">Créer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
