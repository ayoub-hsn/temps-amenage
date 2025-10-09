@extends('admin-etab.layouts.master')
@section('content')
<head>
    <!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
<!-- Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
<!-- DataTables JS -->

<style>
    div.dt-buttons {
        position: relative;
        top: -49%;
        right: 65%;
    }
</style>

</head>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Liste des étudiants</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="etudiant-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <<th>Nom complet</th>
                                        <th>CIN</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Dernier Diplome</th>
                                        <th>Type de diplome</th>
                                        <th>Spécialité</th>
                                        <th>Etablissement</th>
                                        <th>Verification</th>
                                        {{-- <th class="no-export">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>


<script>

    $(document).ready(function () {
        $('#etudiant-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin-etab.passerelle.candidat.index') }}",
            columns: [
                {
                    data: null,
                    name: 'nom',
                    render: function(data, type, row) {
                        return data.nom + ' ' + data.prenom;
                    }
                },
                { data: 'CIN', name: 'CIN' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'dernier_diplome_obtenu', name: 'dernier_diplome_obtenu' },
                { data: 'type_diplome_obtenu', name: 'type_diplome_obtenu' },
                { data: 'specialitediplome', name: 'specialitediplome' },
                { data: 'ville_etablissement_diplome', name: 'ville_etablissement_diplome' },
                { data: 'verif', name: 'verif' },
                // {
                //     data: 'id',
                //     orderable: false,
                //     searchable: false,
                //     render: function (data, type, row) {
                //         return '<a href="/admin-etab/passerelle/candidats/' + data + '" class="btn btn-info btn-sm mr-1">Afficher</a>' +
                //             '<a href="/admin-etab/passerelle/candidats/' + data + '/edit" class="btn btn-warning btn-sm mr-1">Modifier</a>' +
                //             '<button type="button" class="btn btn-danger btn-sm" onclick="annulerConfirmation(' + data + ')">Annuler Confirmation</button>' +
                //             '<a href="/admin-etab/passerelle/candidats/' + data + '/telechargerRecu" class="btn btn-success btn-sm">Télécharger Reçu</a>';
                //     }
                // }
            ],
            order: [[0, 'desc']], // Default sorting by first column
            pageLength: 10, // Number of records per page
            lengthMenu: [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]], // Options for number of records per page
            language: {
                "paginate": {
                    "previous": "Précédent",
                    "next": "Suivant"
                },
                "lengthMenu": "Afficher _MENU_ enregistrements par page",
                "zeroRecords": "Aucun enregistrement trouvé",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
                "infoEmpty": "Affichage de 0 à 0 sur 0 enregistrements",
                "infoFiltered": "(filtré à partir de _MAX_ total des enregistrements)",
                "search": "Rechercher :",
                "processing": "Traitement en cours...",
                "loadingRecords": "Chargement en cours...",
                "emptyTable": "Aucune donnée disponible dans le tableau"
            },
            drawCallback: function () {
                $('#etudiant-table_paginate .pagination li').each(function() {
                    var pageNum = $(this).text();
                    var href = "{{ route('admin-etab.passerelle.candidat.index') }}?page=" + pageNum;
                    $(this).find('a').attr('href', href);
                });
            },
            dom:
            "<'row'<'col-sm-6'l><'col-sm-6'fB>>" +
            "<'row'<'col-sm-12'rt>>" +
            "<'row'<'col-sm-12'i>>" +
            "<'row'<'col-sm-12'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':not(.no-export)' // Exclude columns with the class 'no-export'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':not(.no-export)' // Exclude columns with the class 'no-export'
                    }
                },

            ].filter(Boolean)

        });
    });

    function annulerConfirmation(candidat){
        Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Oui, Annuler!'
            }).then((result) => {
            if (result.isConfirmed) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var url = '{{ route("admin-etab.passerelle.candidat.annulerConfirmation", ":candidat") }}';
                    url = url.replace(':candidat', candidat);
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        console.log(results)
                        if(results.status == 1){
                            $("#etudiant-table").DataTable().ajax.reload(null, false );
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
