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
                        <h4>Liste des étudiants Licences (Accès S5) - {{ $filiere->nom_abrv }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="etudiant-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nom complet</th>
                                        <th>CIN</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Diplome</th>
                                        <th>Spécialité</th>
                                        <th>Mention</th>
                                        <th>Moyenne du Diplome</th>
                                        <th>Verification</th>
                                        <th class="no-export">Action</th>
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
    var filiereId = "{{ $filiere->id }}";
</script>

<script>
    var showDownloadButton = @json($etablissement->multiple_choix_filiere_passerelle == 1);
    var filiereId = {{ $filiere->id }}; // Ensure this is available globally

    $(document).ready(function () {
        $('#etudiant-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin-etab.filiere.licenceExcellence.etudiants.index',['filiere' => $filiere->id]) }}",
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
                { data: 'diplomedeug', name: 'diplomedeug' },
                { data: 'specialitedeug', name: 'specialitedeug' },
                { data: 'mentiondeug', name: 'mentiondeug' },
                { data: 'moyenne_deug', name: 'moyenne_deug' },
                { data: 'verif', name: 'verif' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {

                        let btnShow = '<a href="/admin-etab/filiere/' + filiereId + '/licenceExcellence/etudiant/' + data + '" class="btn btn-info btn-sm mr-1">Afficher</a>';

                        if (row.verifText === 'VERIFIER') {

                            return btnShow +
                                '<button data-url="/admin-etab/filiere/' + filiereId + '/licenceExcellence/etudiant/' + data + '/anullerValidation" class="btn btn-danger btn-sm mr-1 btn-annuler">Annuler la validation</button>';

                        }

                        return btnShow +
                            '<button data-url="/admin-etab/filiere/' + filiereId + '/licenceExcellence/etudiant/' + data + '/valider" class="btn btn-success btn-sm mr-1 btn-valider">Valider</button>';
                    }
                }
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
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
                    var href = "{{ route('admin-etab.filiere.licenceExcellence.etudiants.index',['filiere' => $filiere->id]) }}?page=" + pageNum;
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
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }
            ].filter(Boolean)
        });
    });
</script>
<script>
    $(document).on('click', '.btn-valider', function () {

        let url = $(this).data('url');

        Swal.fire({
            title: 'Valider cet étudiant ?',
            text: "Cette action confirmera la validation.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, valider',
            cancelButtonText: 'Annuler'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: url,
                    type: 'GET',

                    beforeSend: function () {
                        Swal.fire({
                            title: 'Traitement...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },

                    success: function (response) {

                        if (response.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            $('#etudiant-table').DataTable().ajax.reload(null, false);

                        }

                    },

                    error: function () {

                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue'
                        });

                    }

                });

            }

        });

    });
    $(document).on('click', '.btn-annuler', function () {

        let url = $(this).data('url');

        Swal.fire({
            title: 'Annuler la validation ?',
            text: "L'étudiant repassera en statut EN COURS.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, annuler',
            cancelButtonText: 'Fermer'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: url,
                    type: 'GET',

                    beforeSend: function () {
                        Swal.fire({
                            title: 'Traitement...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },

                    success: function (response) {

                        if (response.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            $('#etudiant-table').DataTable().ajax.reload(null, false);

                        }

                    },

                    error: function () {

                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Impossible d\'annuler la validation'
                        });

                    }

                });

            }

        });

    });
</script>


@endsection
