@extends('manager.layouts.manager_master')

@section('title')
    Submission - Manager
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Show Submission</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('manager.submission') }}">Submission</a></li>
            <li class="breadcrumb-item active">Timeline</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
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
<div class="card p-3">
    <div class="timeline">
        <!-- timeline time label -->
        @foreach ($track_subs as $item)
        <div class="time-label">
            <span class="bg-primary">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD MMMM Y') }}</span>
          </div>
          <!-- /.timeline-label -->
          <!-- timeline item -->
          <div>
            @if ($item->status == 1)
            <i class="fas fa-check bg-success"></i>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('HH:mm') }}</span>
              <h3 class="timeline-header"><b>{{ $item->manager }}</b> Granted</h3>
            </div>
            @elseif ($item->status == 2)
            <i class="fas fa-times bg-danger"></i>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('HH:mm') }}</span>
              <h3 class="timeline-header"><b>{{ $item->manager }}</b> Denied</h3>
            </div>
            @endif

          </div>
        @endforeach

      </div>
</div>
@endsection

@section('js')

@endsection
