@extends('layouts.app')

@section('content')
<div class="container">
  <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>order Details</h2>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <a href="{{ route('order.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <br><br>
            <div class="order-title">
                <strong>Title: </strong> {{ $order->title }}
            </div>
            <br>
            <div class="order-description">
                <strong>Description: </strong> {{ $order->description }}
            </div>
            <br>
            <div class="order-description">
                <strong>Status: </strong> {{ $order->status }}
            </div>
        </div>
    </div>
</div>
@endsection