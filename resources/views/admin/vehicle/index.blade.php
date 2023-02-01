@extends('admin.layouts.admin_master')

@section('title')
    Vehicles - Admin
@endsection

@section('title_2')
Vehicles
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
                    <th>Vehicle Number</th>
                    <th>Merk</th>
                    <th>Type</th>
                    <th>Capacity</th>
                    <th>Fuel Ratio</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($vehicle as $item)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$item->vehicle_number}}</td>
                        <td>{{ $item->merk }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->capacity }}</td>
                        <td>{{ $item->fuel_ratio }}</td>
                        @if ($item->status == 0)
                            <td><span class="badge badge-success">Available</span></td>
                        @else
                            <td><span class="badge badge-danger">Booked</span></td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD MMMM Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-success" data-placement="bottom" data-toggle="modal" data-target="#modal-edit{{$item->id}}"><i class="fas fa-pen"></i></button>
                            <button class="btn btn-sm btn-danger" data-placement="bottom" data-toggle="modal" data-target="#modal-clear{{$item->id}}"><i class="fas fa-trash"></i></button>
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
              <h4 class="modal-title">Create New Vehicle</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.vehicle.create') }}" method="post">
                @csrf
                    <div class="form-group">
                      <label for="vehicle number">Vehicle Number</label>
                      <input type="text" name="vehicle_number" required class="form-control" id="vehicle number" placeholder="ex. P 1000 PT">
                    </div>
                    <div class="form-group">
                      <label for="merk">Merk</label>
                      <input type="text" name="merk" required class="form-control" id="merk" placeholder="ex. Honda HRV">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="Gasoline">Gasoline</option>
                            <option value="Diesel">Diesel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity (CC)</label>
                        <input type="text" name="capacity" required class="form-control" id="capacity" placeholder="Input Capacity">
                    </div>
                    <div class="form-group">
                        <label for="fuel_ratio">Fuel Ratio (KM/L)</label>
                        <input type="text" name="fuel_ratio" required class="form-control" id="fuel_ratio" placeholder="Input Fuel Ratio">
                        <input type="text" name="status" value="0" hidden>
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
      @foreach ($vehicle as $item)
        <div class="modal fade" id="modal-edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.vehicle.update') }}" method="post">
                        @csrf
                            <div class="form-group">
                              <label for="vehicle number">Vehicle Number</label>
                              <input type="text" value="{{ $item->vehicle_number }}" name="vehicle_number" required class="form-control" id="vehicle number" placeholder="ex. P 1000 PT">
                            </div>
                            <div class="form-group">
                              <label for="merk">Merk</label>
                              <input type="text" value="{{ $item->merk }}" name="merk" required class="form-control" id="merk" placeholder="ex. Honda HRV">
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="Gasoline" @if ($item->type == "Gasoline") {{'selected="selected"'}} @endif>Gasoline</option>
                                    <option value="Diesel" @if ($item->type == "Diesel") {{'selected="selected"'}} @endif>Diesel</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="capacity">Capacity (CC)</label>
                                <input type="text" value="{{ $item->capacity }}" name="capacity" required class="form-control" id="capacity" placeholder="Input Capacity">
                            </div>
                            <div class="form-group">
                                <label for="fuel_ratio">Fuel Ratio (KM/L)</label>
                                <input type="text" value="{{ $item->fuel_ratio }}" name="fuel_ratio" required class="form-control" id="fuel_ratio" placeholder="Input Fuel Ratio">
                                <input type="text" name="status" value="{{ $item->status }}" hidden>
                                <input type="text" name="edit_id" value="{{ $item->id }}" hidden>
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
    @foreach ($vehicle as $item)
    <div class="modal fade" id="modal-clear{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Clear Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.vehicle.delete') }}" method="post">
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
