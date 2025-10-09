@extends('admin-etab.layouts.master')
@section('content')

<style>
    .select2-container {
        width: 100% !important;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Envoyer un Message</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin-etab.notification.store')}}" method="post">
                            @csrf

                            <div class="row">
                                <!-- Étudiants Master -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="etudiantsMaster">Sélectionner les candidats Master</label>
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="selectAll('etudiantsMaster')">Tout sélectionner</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger mb-2" onclick="deselectAll('etudiantsMaster')">Tout désélectionner</button>
                                        <select name="etudiantsMaster[]" id="etudiantsMaster" class="form-control select2" multiple>
                                            @foreach($etudiantsMaster as $etudiant)
                                                <option value="{{ $etudiant->user_id }}">{{ $etudiant->nom }} {{ $etudiant->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Étudiants Licence -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="etudiantsLicence">Sélectionner les candidats Licence</label>
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="selectAll('etudiantsLicence')">Tout sélectionner</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger mb-2" onclick="deselectAll('etudiantsLicence')">Tout désélectionner</button>
                                        <select name="etudiantsLicence[]" id="etudiantsLicence" class="form-control select2" multiple>
                                            @foreach($etudiantsLicence as $etudiant)
                                                <option value="{{ $etudiant->user_id }}">{{ $etudiant->nom }} {{ $etudiant->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Titre du message -->
                            <div class="form-group mt-3">
                                <label for="titre">Titre du message</label>
                                <input type="text" name="titre" id="titre" value="{{ old('titre') }}" class="form-control {{ $errors->has('titre') ? 'is-invalid' : '' }}">
                                @if($errors->has('titre'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('titre') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Contenu du message -->
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="message" id="message" rows="5" class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}">{{ old('message') }}</textarea>
                                @if($errors->has('message'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Bouton submit -->
                            <button class="btn btn-primary btn-block">Envoyer</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Initialiser Select2
        $(document).ready(function() {
            $('.select2').select2();
        });

        // Sélectionner tout
        function selectAll(selectId) {
            let $select = $('#' + selectId);
            $select.find('option').prop('selected', true);
            $select.trigger('change'); // mettre à jour Select2
        }

        // Désélectionner tout
        function deselectAll(selectId) {
            let $select = $('#' + selectId);
            $select.find('option').prop('selected', false);
            $select.trigger('change'); // mettre à jour Select2
        }
    </script>
</div>


@endsection
