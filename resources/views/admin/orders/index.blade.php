@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
      <h1>Orders</h1>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Order Requests</h4>
                <div class="card-header-form">
                    <form action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
                            <div class="input-group-btn">
                                <button type="submit" style="height: 40px;" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>User Name</th>
                            <th>Pickup Location</th>
                            <th>Delivery Location</th>
                            <th>Size</th>
                            <th>Weight</th>
                            <th>Pickup Time</th>
                            <th>Delivery Time</th>
                            <th>Status</th>

                            <th style="width: 20%">Action</th>
                        </tr>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->user->name }}</td>
                                <td>

                                    <div class="d-flex">
                                        <div>
                                            <span>{{ $order->pickup_location }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span>{{ $order->delivery_location }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span>{{ $order->size }}</span>
                                </td>
                                <td>
                                    <span>{{ $order->weight }}</span>
                                </td>
                                <td>{{ formatDate($order->pickup_time) }}</td>
                                <td>{{ formatDate($order->delivery_time) }}</td>
                                <td>
                                    @if ($order->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($order->status === 'in_progress')
                                        <span class="badge bg-info text-dark">In Progress</span>
                                    @elseif($order->status === 'delivered')
                                    <span class="badge bg-success text-dark">Delivered</span>
                                    @else
                                        <span class="badge bg-danger text-dark">Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.order.edit', $order->id) }}" class="btn-sm btn btn-primary"><i class="fas fa-cog"></i></a>
                                    <a href="{{ route('admin.order.delete', $order->id) }}" class="btn-sm btn btn-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No result found!</td>
                            </tr>
                        @endforelse

                    </tbody>

                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <nav class="d-inline-block">
                    @if ($orders->hasPages())
                        {{ $orders->withQueryString()->links() }}
                    @endif
                </nav>
            </div>
        </div>
    </div>

  </section>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
