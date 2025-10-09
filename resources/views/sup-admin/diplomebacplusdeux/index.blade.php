@extends('sup-admin.layouts.master')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary" style="justify-content: space-between;">
                        <h4>Liste des diplomes du Bac+2</h4>
                        <a href="{{ route('sup-admin.diplomebacplusdeux.create') }}" class="btn btn-light btn-sm">
                            Ajouter un diplome
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nom Complet</th>
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
            ajax: "{{ route('sup-admin.diplomebacplusdeux.index') }}",
            columns: [
                {data: 'nom', name: 'nom'},
               
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


</script>
@endsection
