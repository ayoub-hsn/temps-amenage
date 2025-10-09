@extends('sup-admin.layouts.master')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Créer une actualité</h4>
                        <a href="{{route('sup-admin.actualite.index')}}" class="btn btn-primary">Liste des actualites</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('sup-admin.actualite.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Titre</label>
                                        <input type="text" name="titre" value="{{old('titre')}}" class="form-control {{ $errors->has('titre') ? 'is-invalid' : '' }}">
                                        @if($errors->has('titre'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('titre') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Publier</label>
                                                <input type="date" name="published_at" value="{{old('published_at')}}" class="form-control {{ $errors->has('published_at') ? 'is-invalid' : '' }}">
                                                @if($errors->has('published_at'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('published_at') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Finished</label>
                                                <input type="date" name="finished_at" value="{{old('finished_at')}}" class="form-control {{ $errors->has('published_at') ? 'is-invalid' : '' }}">
                                                @if($errors->has('finished_at'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('published_at') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" class="summernote">{{old('description')}}</textarea>
                                        @if($errors->has('description'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('description') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label for="">Image</label>
                                    <input type="file" class="filepond" name="file" id="filepond" accept="image/png, image/jpeg, image/jpg, image/webp" data-max-file-size="400KB">
                                    @if($errors->has('file'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('file') }}
                                        </div>
                                    @endif
                                </div>
                                <button class="btn btn-primary btn-block">Créer</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        const input = document.querySelector('input[id="filepond"]');

        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
        );
        const pond=FilePond.create(input,
            {
            labelIdle: `Déposez l'image ici`,
            labelFileProcessing: 'Traitement en cours',
            labelFileProcessingComplete: 'Traitement terminé',
            labelFileProcessingAborted: 'Traitement annulé',
            labelFileProcessingError: 'Erreur de traitement',
            labelTapToCancel: 'Appuyez pour annuler',
            labelTapToRetry: 'Appuyez pour réessayer',
            labelTapToUndo: 'Appuyez pour annuler',
            labelButtonRemoveItem: 'Supprimer',
            labelFileTypeNotAllowed: 'Type de fichier non autorisé. Seuls les fichiers png, jpeg, jpg, webp sont autorisés.'
            }
        );


        // pond.addFile(mainPictureUrl);
        FilePond.setOptions({
            server:{
                url:'{{ route('sup-admin.etablissement.storeMedia') }}',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },

            },
            success: function (file, response) {
                console.log(response.name)
                $('form').append('<input type="hidden" name="file[]" value="' + response.name + '">')

            },

        });
    </script>
  


@endsection
