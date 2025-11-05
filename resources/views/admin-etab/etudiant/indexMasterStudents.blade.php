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
                                        <th>Nom complet</th>
                                        <th>CIN</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Licence</th>
                                        <th>Spécialité</th>
                                        <th>Moyenne</th>
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
    var showDownloadButton = @json($etablissement->multiple_choix_filiere_master == 1);
    $(document).ready(function () {
        $('#etudiant-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin-etab.filiere.master.etudiants.index',['filiere' => $filiere->id]) }}",
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
                { data: 'typelicence', name: 'typelicence' },
                { data: 'specialitelp', name: 'specialitelp' },
                { data: 'moyenne_licence', name: 'moyenne_licence' },
                { data: 'verif', name: 'verif' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return '<a href="/admin-etab/filiere/' + filiereId + '/master/etudiant/' + data + '" class="btn btn-info btn-sm mr-1">Afficher</a>';
                    }
                }
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
                    var href = "{{ route('admin-etab.filiere.master.etudiants.index',['filiere' => $filiere->id]) }}?page=" + pageNum;
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
                // !showDownloadButton ? {
                //     text: 'Télécharger la liste Complète',
                //     action: function (e, dt, node, config) {
                //         let form = document.createElement('form');
                //         form.method = 'POST';
                //         form.action = '{{ route('admin-etab.filiere.master.etudiants.excel.download', ['filiere' => $filiere->id]) }}';

                //         let csrfInput = document.createElement('input');
                //         csrfInput.type = 'hidden';
                //         csrfInput.name = '_token';
                //         csrfInput.value = '{{ csrf_token() }}';
                //         form.appendChild(csrfInput);

                //         document.body.appendChild(form);
                //         form.submit();
                //     },
                //     className: 'btn btn-primary mr-2'
                // } : null,
                // {
                //     text: 'Liste des étudiants sélectionnés',
                //     className: 'btn btn-success',
                //     action: function () {
                //         window.location.href = "{{ route('admin-etab.filiere.master.etudiants.listToselect', ['filiere' => $filiere->id]) }}";
                //     }
                // }
            ].filter(Boolean)

        });
    });
</script>

@endsection
