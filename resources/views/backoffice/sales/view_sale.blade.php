@extends('layouts.admin_app')

@section('title')
   View Sale Details
@endsection

@section('content')
<div id="app">
    <view-sale-component :sale-id="{{ $id }}"></view-sale-component>
</div>
@endsection 