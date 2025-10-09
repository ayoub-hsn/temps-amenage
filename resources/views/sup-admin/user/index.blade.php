@extends('sup-admin.layouts.master')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary" style="justify-content: space-between;">
                        <h4>Liste des utilisateurs</h4>
                        {{-- <a href="{{ route('sup-admin.user.create') }}" class="btn btn-light btn-sm">
                            Ajouter un utilisateur
                        </a> --}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nom Complet</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Etablissement</th>
                                        <th>Role</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>


    $(function () {


        var table = $('#save-stage').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('sup-admin.user.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'telephone', name: 'telephone'},
                {data: 'email', name: 'email'},
                {data: 'etablissement', name: 'etablissement'},
                {data: 'role', name: 'role'},
                {data: 'active', name: 'active'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            orderCellsTop: true,
            order: [[ 0, 'desc' ]],
            pageLength: 25,
        });


        $('.table thead').on('input', '.search', function () {
            let strict = $(this).attr('strict') || false
            let value = strict && this.value ? "^" + this.value + "$" : this.value

            let index = $(this).parent().index()
            table.column(index).search(value, strict).draw()

        });

    });

    function activerUser(user){
        Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Oui, Activer!'
            }).then((result) => {
            if (result.isConfirmed) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var url = '{{ route("sup-admin.user.active", ":user") }}';
                    url = url.replace(':user', user);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if(results.status == 1){
                            $("#save-stage").DataTable().ajax.reload(null, false );
                            Swal.fire("Success!", results.message, "success");
                        }else{
                            Swal.fire("Erreur!", results.message, "error");
                        }
                    },
                    error: function(error) {
                        Swal.fire("Erreur!", 'Refaire cette action aprés', "error");
                        console.log(error)
                    }
                });

            }else{
                result.dismiss;
            }
            }, function (dismiss) {
                return false;
            })
    }

    function desactiverUser(user){
        Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Oui, Desactiver!'
            }).then((result) => {
            if (result.isConfirmed) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var url = '{{ route("sup-admin.user.desactive", ":user") }}';
                    url = url.replace(':user', user);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if(results.status == 1){
                            $("#save-stage").DataTable().ajax.reload(null, false );
                            Swal.fire("Success!", results.message, "success");
                        }else{
                            Swal.fire("Erreur!", results.message, "error");
                        }
                    },
                    error: function(error) {
                        Swal.fire("Erreur!", 'Refaire cette action aprés', "error");
                        console.log(error)
                    }
                });

            }else{
                result.dismiss;
            }
            }, function (dismiss) {
                return false;
            })
    }

</script>
@endsection
