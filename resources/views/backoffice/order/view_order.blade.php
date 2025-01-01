@extends('layouts.admin_app')

@section('title')
   View Order
@endsection

@section('content')
<div id="app">
    <view-order-component :order-id="{{ $id }}"></view-order-component>
</div>
@endsection 