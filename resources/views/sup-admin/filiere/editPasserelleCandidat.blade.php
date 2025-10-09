@extends('sup-admin.layouts.master')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Modifier Mot de Passe du Candidat</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sup-admin.passerelle.candidat.update',['candidat' => $user->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Nom complet</label>
                                        <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" disabled>
                                        @if($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Telephone</label>
                                        <input type="text" name="telephone" value="{{old('telephone',$user->telephone)}}" class="form-control {{ $errors->has('telephone') ? 'is-invalid' : '' }}" disabled>
                                        @if($errors->has('telephone'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('telephone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" value="{{old('email',$user->email)}}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" disabled>
                                        @if($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Mot de passe</label>
                                        <input type="password" name="password" value="" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                                        @if($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-primary btn-block">Modifier</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection
