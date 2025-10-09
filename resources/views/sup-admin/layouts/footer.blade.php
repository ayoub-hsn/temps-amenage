<script src="{{asset('dashboard/js/app.min.js')}}"></script>
<script src="{{asset('dashboard/bundles/prism/prism.js')}}"></script>
  <script src="{{asset('dashboard/bundles/summernote/summernote-bs4.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('dashboard/bundles/apexcharts/apexcharts.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('dashboard/js/page/index.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('dashboard/bundles/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{asset('dashboard/bundles/jquery-selectric/jquery.selectric.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('dashboard/js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{asset('dashboard/js/custom.js')}}"></script>
  <script src="{{asset('dashboard/bundles/datatables/datatables.min.js')}}"></script>
  {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
  <script src="{{asset('dashboard/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.js"></script>



  <script src="{{ asset('dashboard/js/toastr.min.js')}}"></script>

  <script>
    $(document).ready(function() {
      toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
    }
        @if (Session::has('message'))
          toastr.success('{{ Session::get('message') }}');
        @endif
        @if (Session::has('warning'))
          toastr.warning('{{ Session::get('warning') }}');
        @endif
        @if (Session::has('error'))
          toastr.error('{{ Session::get('error') }}');
        @endif
    });
</script>