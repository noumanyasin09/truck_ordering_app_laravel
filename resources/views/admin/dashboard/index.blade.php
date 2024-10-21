@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-truck-moving"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Order Requests</h4>
            </div>
            <div class="card-body">
            {{ $totalOrders }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-laugh"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Delivered Requests</h4>
            </div>
            <div class="card-body">
                {{ $deliveredRequests }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-pause"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pending Request</h4>
            </div>
            <div class="card-body">
                {{ $pendingRequests }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-spinner"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>In Progress Requests</h4>
            </div>
            <div class="card-body">
                {{ $inProcessRequests }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-frown"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Canceled Requests</h4>
            </div>
            <div class="card-body">
                {{ $canceledRequests }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-user-friends"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Users</h4>
            </div>
            <div class="card-body">
                {{ $totalUsers }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
