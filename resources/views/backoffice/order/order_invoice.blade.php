<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-size: 120%;
        }

        @media print {
            body {
                width: 80mm;
                height: 210mm;
            }
        }



        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            text-align: left;
            background-color: #f2f2f2;
            padding: 8px;
            font-weight: normal;
        }

        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media screen and (max-width: 600px) {
            table {
                font-size: 12px;
            }
            th, td {
                padding: 4px;
            }
        }

        h2, h3, p, h1 {
            margin: 5px 0;
        }

        .footer {
            margin-top: 0px;
        }

        /* added style */
        .previous-div {
            margin-bottom: 10px;
        }

        .center {
            width: 75%; /* set the width of the div */
            margin: 0 auto; /* center the div horizontally */
            padding: 10px;
        }
    </style>
</head>
<body>
<div style="text-align: center;">
    <div >
        <h1 class="title"><strong>HOSCHEM</strong>  </h1>
        <span>Pharmacy</span>
        <h3>Kawangware 46</h3>
        <p> TEL: 0727314538, 0712627858</p>
        <p> hellenborundo@gmail.com</p>
        <p>Receipt No. : {{$order->invoice_no}}</p>
        <h1> CASH SALE</h1>
        <p>DATE: {{$order->order_date}}</p>

    </div>

</div>
<h3>{{$order->customer->name}}</h3>
<div class="previous-div">
    <table>
        <thead>

        <tr class="font">
            <th>ITEM</th>
            <th>CODE</th>
            <th>QTY</th>
            <th>PRICE</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orderItem as $item)
            <tr class="font">

                <td align="center">{{$item->product->product_name}} </td>

                <td align="center">{{$item->product->product_code}} </td>
                <td align="center"> {{$item->quantity}} </td>
                <td align="center">{{$item->product->selling_price}} </td>
                <td align="center"> {{$item->total}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div width="100%" style=" padding:0 10px 0 10px;">
        <div>
            <div align="right" >
{{--                <p><strong>Subtotal: </span>KES {{$order->sub_total}}</strong></p>--}}
{{--                <h4>Tax: </span>KES {{$o@php
    $id= Auth::user()->id;
$data= \App\Models\User::find($id);
@endphprder->vat}}</h4>--}}
                <p><strong>Total: </span>{{$order->total}}</strong> </p>
                {{-- <h2><span style="color: green;">Full Payment PAID</h2> --}}
            </div>
        </div>
    </div>
    <div class="thanks mt-3">
        <p>Thanks For Buying Our Products..!!</p>
    </div>

    <div class="authority float-right mt-5 text-center" >
        <h5>You Were Served by: {{$data->name}}</h5><hr>
        <h3>Pay Bill: 522533 <br> Account No: 7587651 </h3>
        <h3> Name: HosChem</h3><hr>
    </div>
    <div class="footer">
        <p><strong> Wabe*Point Pos
       <br> TEL: 0781312070</strong></p>

    </div>
</body>
</html>
