@extends('admin.layouts.admin_master')

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
    <!-- /.card-header -->
    <div class="float-left mt-3 ml-3">
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-create"><i class="fas fa-plus-square"></i> Create</button>
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
                            @elseif ($item->status == 2)
                            <span class="badge badge-danger">Denied</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status == 1)
                                {{ \Carbon\Carbon::parse($item->date_allowed)->isoFormat('DD MMMM Y') }}
                            @elseif ($item->status == 0)
                                <span class="badge badge-primary">On Process</span>
                            @elseif ($item->status == 2)
                                <span class="badge badge-danger">Denied</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.submission.show', [$item->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <button title="Edit" class="btn btn-sm btn-success" data-placement="bottom" data-toggle="modal" data-target="#modal-edit{{$item->id}}"><i class="fas fa-pen"></i></button>
                            @if ($item->status == 1)
                            <button title="Return" class="btn btn-sm btn-warning" data-placement="bottom" data-toggle="modal" data-target="#modal-return{{$item->id}}"><i class="fa fa-arrow-left"></i></button>
                            @endif
                            <button title="Delete" class="btn btn-sm btn-danger" data-placement="bottom" data-toggle="modal" data-target="#modal-clear{{$item->id}}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="modal fade" id="modal-create" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create New Submission</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.submission.create') }}" method="post">
                @csrf
                    <div class="form-group">
                      <label for="employee_name">Employee Name</label>
                      <select name="employee_id" id="employee_id" required class="form-control">
                            @foreach ($employee as $item)
                                <option value="{{ $item->id }}" >{{ $item->employee_name }} - {{ $item->position }}</option>
                            @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="position">Vehicle</label>
                      <select name="vehicle_id" id="vehicle_id" required class="form-control">
                        @foreach ($vehicle as $item)
                            <option value="{{ $item->id }}" >{{ $item->merk}} - {{ $item->vehicle_number }}</option>
                        @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      @foreach ($submission as $item)
        <div class="modal fade" id="modal-edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Submission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.submission.update') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="employee_name">Employee Name</label>
                            <select name="employee_id" id="employee_id" required class="form-control">
                                  @foreach ($employee as $v)
                                      <option value="{{ $v->id }}" @if($item->employee_id == $v->id) {{'selected="selected"'}} @endif>{{ $v->employee_name }} - {{ $v->position }}</option>
                                  @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="position">Vehicle</label>
                            <select name="vehicle_id" id="vehicle_id" required class="form-control">
                              @foreach ($vehicle as $v)
                                  <option value="{{ $v->id }}" @if($item->vehicle_id == $v->id) {{'selected="selected"'}} @endif>{{ $v->merk}} - {{ $v->vehicle_number }}</option>
                              @endforeach
                              </select>
                              <input type="text" value="{{ $item->id }}" name="edit_id" hidden>
                          </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
        </div>
    @endforeach
    @foreach ($submission as $item)
    <div class="modal fade" id="modal-return{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Submission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.submission.return') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Are you sure to return the vehicle ?</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
                            <input type="text" value="{{$item->id}}" hidden name="submission_id">
                            <button type="submit" class="btn btn-warning text-dark">Return</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @foreach ($submission as $item)
    <div class="modal fade" id="modal-clear{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Submission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.submission.delete') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Are you sure to delete the vehicle ?</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
                            <input type="text" id="delete_id" value="{{$item->id}}" hidden name="delete_id">
                            <button type="submit" class="btn btn-primary">Delete</button>
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
