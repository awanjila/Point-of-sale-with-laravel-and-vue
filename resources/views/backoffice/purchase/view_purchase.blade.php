@extends('layouts.admin_app')

@section('title')
   View Purchase
@endsection

@section('content')
<div id="app">
    <view-purchase-component :purchase-id="{{ $id }}"></view-purchase-component>
</div>
@endsection 