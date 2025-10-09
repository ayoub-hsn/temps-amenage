@extends('sup-admin.layouts.master')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Modifier un etablissement</h4>
                        <a href="{{route('sup-admin.etablissement.index')}}" class="btn btn-primary">Liste des etablissements</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('sup-admin.etablissement.update',['etablissement' => $etablissement->id])}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                   <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Nom abréviation</label>
                                            <input type="text" name="nom_abrev" value="{{old('nom_abrev',$etablissement->nom_abrev)}}" class="form-control {{ $errors->has('nom_abrev') ? 'is-invalid' : '' }}">
                                            @if($errors->has('nom_abrev'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('nom_abrev') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <label for="">nom</label>
                                            <input type="text" name="nom" value="{{old('nom',$etablissement->nom)}}" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}">
                                            @if($errors->has('nom'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('nom') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                   </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-11">     
                                            <div class="form-group">
                                                <label for="responsable_id">Responsable</label>
                                                <select name="responsable_id" class="form-control select2 {{ $errors->has('responsable_id') ? 'is-invalid' : '' }}" id="responsable_id">
                                                    <option value="" selected>Choisir le responsable</option>
                                                    @foreach ($responsables as $responsable)
                                                        <option value="{{$responsable->id}}" {{ old('responsable_id',$etablissement->responsable_id) == $responsable->id ? 'selected' : '' }}>{{ $responsable->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('responsable_id'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('responsable_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <label for="button" style="visibility: hidden;">button</label>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createResponsableModal"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{old('description',$etablissement->description)}}</textarea>
                                        @if($errors->has('description'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('description') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                           
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label for="">Logo</label>
                                    <input type="file" class="filepond" name="file" id="filepond" accept="image/png, image/jpeg, image/jpg, image/webp" data-max-file-size="400KB">
                                    @if($errors->has('file'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('file') }}
                                        </div>
                                    @endif
                                </div>
                                <button class="btn btn-primary btn-block">Modifier</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="createResponsableModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="formModal">Créer un responsable</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form class="">
                <div class="form-group">
                    <label>Nom complet</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                        </div>
                        <input type="text" id="name" class="form-control" placeholder="Nom complet" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </div>
                        </div>
                        <input type="text" id="email" class="form-control" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label>Téléphone</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </div>
                        </div>
                        <input type="text" id="phone" class="form-control" placeholder="Téléphone" name="phone">
                    </div>
                </div>
                <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </div>
                    </div>
                    <input type="password" id="password" class="form-control" placeholder="Password" name="password">
                </div>
                </div>
                <button type="button" style="width: 100%;" class="btn btn-primary m-t-15 waves-effect" id="buttonClickResponsable">Enregistrer</button>
            </form>
            </div>
        </div>
        </div>
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
            labelIdle: `Déposez le logo ici`,
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
   <script>
        $(document).ready(function () {
            $('#buttonClickResponsable').on('click', function () {
                // Get field values
                let name = $("#name").val().trim();
                let email = $("#email").val().trim();
                let phone = $("#phone").val().trim();
                let password = $("#password").val().trim();

                // Flag to track validation status
                let isValid = true;

                // Clear previous errors
                $(".form-control").removeClass("is-invalid");
                $(".form-group .error-message").remove();

                // Check each field and display error if empty
                if (!name) {
                setInvalid("#name", "Ce champ est requis.");
                isValid = false;
                }
                if (!email) {
                    setInvalid("#email", "Ce champ est requis.");
                    isValid = false;
                } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                    setInvalid("#email", "Veuillez entrer un email valide.");
                    isValid = false;
                }
                if (!phone) {
                    setInvalid("#phone", "Ce champ est requis.");
                    isValid = false;
                } else if (!/^\d{10}$/.test(phone)) {
                    setInvalid("#phone", "Veuillez entrer un numéro de téléphone valide (10 chiffres).");
                    isValid = false;
                }
                if (!password) {
                    setInvalid("#password", "Ce champ est requis.");
                    isValid = false;
                } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/.test(password)) {
                    setInvalid("#password", "Le mot de passe doit être d'au moins 8 caractères, contenir des majuscules, des minuscules, un chiffre et un caractère spécial.");
                    isValid = false;
                }

                // If not valid, block the function
                if (!isValid) {
                    return;
                }

                // Proceed with AJAX request if all fields are valid
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url = '{{ route("sup-admin.responsable.create") }}';

                $.ajax({
                    type: 'POST', // Change to POST method
                    url: url,
                    data: {
                        _token: CSRF_TOKEN, 
                        name: name,
                        email: email,
                        telephone: phone,
                        password: password
                    },
                    dataType: 'JSON',
                    success: function (results) {
                       console.log(results)
                        // Clear the form fields
                        $('#name').val('');
                        $('#email').val('');
                        $('#phone').val('');
                        $('#password').val('');

                        // Close the modal
                        $('#createResponsableModal').modal('hide');
                        $('#responsable_id').append(results.option);
                        Swal.fire("Success!", results.message, "success");
                    },
                    error: function (error) {
                        // Check if the response contains validation errors
                        if (error.status === 422) { // 422 Unprocessable Entity
                            let errors = error.responseJSON.errors;
                            let errorMessage = '';

                            // Loop through the errors and concatenate them
                            for (let field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessage += `${errors[field].join('<br>')}<br>`;
                                }
                            }

                            // Display the errors in SweetAlert
                            Swal.fire({
                                icon: "error",
                                title: "Erreur de validation!",
                                html: errorMessage, // Use HTML to format the messages
                            });
                        } else {
                            // For other errors, display a generic message
                            Swal.fire("Erreur!", "Refaire cette action après", "error");
                            console.log(error); // Log the error for debugging
                        }
                    }
                });
            });

            $(".form-control").on("input", function () {
                $(this).removeClass("is-invalid"); // Remove red border
                $(this).closest(".form-group").find(".error-message").remove(); // Remove error message
            });

            // Function to set field as invalid and display error message
            function setInvalid(selector, message) {
                // Add is-invalid class to input field
                $(selector).addClass("is-invalid");

                // Append error message below the input field
                $(selector)
                    .closest(".input-group") // Ensure correct placement in the input group
                    .after(`<small class="error-message text-danger">${message}</small>`);
            }
        });
    </script>


@endsection
