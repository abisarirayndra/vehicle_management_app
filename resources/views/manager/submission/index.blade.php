@extends('manager.layouts.manager_master')

@section('title')
    Submission - Admin
@endsection

@section('title_2')
Submission
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
    <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Submission Date</th>
                    <th>Employee Name</th>
                    <th>Vehicle</th>
                    <th>Vehicle Number</th>
                    <th>Status</th>
                    <th>Date Allowed</th>
                    <th>Action</th>
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
                            {{ \Carbon\Carbon::parse($item->date_allowed)->isoFormat('DD MMMM Y') }}
                        </td>
                        <td>{{$item->employee_name}}</td>
                        <td>{{$item->merk}}</td>
                        <td>{{ $item->vehicle_number }}</td>
                        <td>
                            @if ($item->status == 1)
                            <span class="badge badge-success">Granted</span>
                            @elseif ($item->status == 0)
                            <span class="badge badge-primary">On Process</span>
                            @else
                            <span class="badge badge-danger">Denied</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status == 1)
                                {{ \Carbon\Carbon::parse($item->date_allowed)->isoFormat('DD MMMM Y') }}
                            @elseif ($item->status == 0)
                                <span class="badge badge-primary">On Process</span>
                            @else
                                <span class="badge badge-danger">Denied</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('manager.submission.show', [$item->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <button title="Grant" class="btn btn-sm btn-success" data-placement="bottom" data-toggle="modal" data-target="#modal-granted{{$item->id}}"><i class="fas fa-check"></i> </button>
                            <button title="Deny" class="btn btn-sm btn-danger" data-placement="bottom" data-toggle="modal" data-target="#modal-denied{{$item->id}}"><i class="fas fa-times"></i> </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    @foreach ($submission as $item)
    <div class="modal fade" id="modal-granted{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Grant The Submission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('manager.submission.action') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Are you sure to grant the submission ?</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
                            <input type="text" id="grant_id" value="{{$item->id}}" hidden name="submission_id">
                            <input type="text" id="status" value="1" hidden name="status">
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @foreach ($submission as $item)
    <div class="modal fade" id="modal-denied{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Grant The Submission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('manager.submission.action') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Are you sure to deny the submission ?</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
                            <input type="text" id="grant_id" value="{{$item->id}}" hidden name="submission_id">
                            <input type="text" id="status" value="2" hidden name="status">
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
  </div>
@endsection

@section('js')
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
