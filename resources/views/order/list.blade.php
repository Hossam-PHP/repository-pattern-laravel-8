@extends('layouts.app')

@section('content')
<div class="container">

<div class="card card-block">
    <h2 class="card-title">Softxpert Task
        <small>Welcome in Order Dashboard</small>
    </h2>
    <button id="btn-add" name="btn-add" class="btn btn-primary btn-xs">Add New Details</button>
</div>

<div>
    <table class="table table-inverse">
        <thead>
        <tr>
            <th>ID</th>
            <th>Details</th>
            <th>Client</th>
            <th>Edit or Delete</th>
        </tr>
        </thead>
        <tbody id="orders-list" name="orders-list">
        @foreach ($orders as $order)
            <tr id="order{{$order->id}}">
                <td>{{$order->id}}</td>
                <td>{{$order->details}}</td>
                <td>{{$order->client}}</td>
                <td>
                    <button class="btn btn-info open-modal" value="{{$order->id}}">Edit
                    </button>
                    <button class="btn btn-danger delete-order" value="{{$order->id}}">Delete
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-felx justify-content-center">

            {{ $orders->links() }}

        </div>
    
    <div class="modal fade" id="orderEditorModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="orderEditorModalLabel">Details Editor</h4>
                </div>
                <div class="modal-body">
                    <form id="modalFormData" name="modalFormData" class="form-horizontal" novalidate="">

                        <div class="form-group">
                            <label for="inputDetails" class="col-sm-2 control-label">Details</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="details" name="details"
                                       placeholder="Enter Details" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Client</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client" name="client"
                                       placeholder="Enter Details Client" value="">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                    </button>
                    <input type="hidden" id="order_id" name="order_id" value="0">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection