@extends('admin.layouts.admin_master')

@section('title')
    Submission - Admin
@endsection

@section('title_2')
Submission History
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <h5><i class="icon fas fa-check"></i> Alert!</h5>
            <p>{{ session()->get('success') }}</p>
        </div>
    @endif
    @if (session()->has('errors'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            <p>{{ session()->get('errors') }}</p>
        </div>
    @endif
<div class="card">
    <div class="mt-3 ml-3">
        <form action="{{ route('admin.submission.history') }}" method="GET">
            <div class="form-row">
                <div class="form-group ml-2">
                    <label for="month">Month</label>
                    <input type="text" required class="form-control" id="datepicker-month" name="month" placeholder="Input Month" autocomplete="off"/>
                </div>
                <div class="form-group ml-2">
                    <label for="year">Year</label>
                    <input type="text" required class="form-control" id="datepicker-year" name="year" placeholder="Input Year" autocomplete="off"/>
                </div>

            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-warning" type="submit"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Submission Date</th>
                    <th>Employee Name</th>
                    <th>Vehicle</th>
                    <th>Vehicle Number</th>
                    <th>Status</th>
                    <th>Date Allowed</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($submission as $item)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD MMMM Y') }}
                        </td>
                        <td>{{$item->employee_name}}</td>
                        <td>{{$item->merk}}</td>
                        <td>{{ $item->vehicle_number }}</td>
                        <td>
                            @if ($item->status == 1)
                            <span class="badge badge-success">Granted</span>
                            @elseif ($item->status == 2)
                            <span class="badge badge-danger">Denied</span>
                            @elseif ($item->status == 3)
                            <span class="badge badge-warning text-dark">Returned</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status == 1)
                                {{ \Carbon\Carbon::parse($item->date_allowed)->isoFormat('DD MMMM Y') }}
                            @elseif ($item->status == 2)
                                <span class="badge badge-danger">Denied</span>
                            @elseif ($item->status == 3)
                                <span class="badge badge-warning text-dark">Returned</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
  <script>
      $("#datepicker-month").datepicker( {
      format: "mm",
      startView: "months",
      minViewMode: "months"
  });
  $("#datepicker-year").datepicker( {
      format: "yyyy",
      startView: "years",
      minViewMode: "years"
  });
  </script>
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endsection
