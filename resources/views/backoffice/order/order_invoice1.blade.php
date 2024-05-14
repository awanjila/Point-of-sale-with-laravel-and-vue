<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
        .font{
            font-size: 15px;
        }
        .authority {
            /*text-align: center;*/
            float: right
        }
        .authority h5 {
            margin-top: -10px;
            color: #0f570c;
            /*text-align: center;*/
            margin-left: 35px;
        }
        .thanks p {
            color: #0f570c;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>

</head>
<body>

<table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
            <!-- {{-- <img src="" alt="" width="150"/> --}} -->
            <h2 style="color: midnightblue; font-size: 26px;" class="text-center"><strong>HosChem Pharmacy</strong></h2>
        </td>
        <td align="right">
            <pre class="font" >
               HosChem Pharmacy <br>
               12374, 20100 <
               Mob: 0712627858 <br>

            </pre>
        </td>
    </tr>

</table>


<table width="100%" style="background:white; padding:2px;"></table>

<table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
    <tr>
        <td>
            <p class="font" style="margin-left: 20px;">
                <strong>Customer Name: {{$order->customer->name}}</strong>   <br>
                <strong>Customer Email: {{$order->customer->email}}</strong>   <br>
                <strong>Customer Phone: {{$order->customer->phone}}</strong>   <br>

                <strong>Address: {{$order->customer->address}}</strong>
                <strong>Shop Name:</strong>

            </p>
        </td>
        <td>
            <p class="font">
            <h3><span style="color: midnightblue;">Invoice:</span> # {{$order->invoice_no}} </h3>
            Order Date: {{$order->order_date}}  <br>
            Order Status: {{$order->order_status}}  <br>
            Payment Status:  {{$order->payment_status}}  <br>
            Total Pay :   {{$order->pay}}<br>
            Total Due :  {{$order->due}} </span>

            </p>
        </td>
    </tr>
</table>
<br/>
<h3>Products</h3>


<table width="100%">
    <thead style="background-color: midnightblue; color:#FFFFFF;">
    <tr class="font">
        <th>Product Name</th>
        <th>Product Code</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total(+Vat)</th>
    </tr>
    </thead>
    <tbody>

    @foreach($orderItem as $item)
        <tr class="font">

            <td align="center">{{$item->product->product_name}} </td>

            <td align="center">{{$item->product->product_code}} </td>
            <td align="center"> {{$item->quantity}} </td>
            <td align="center">KES {{$item->product->selling_price}} </td>
            <td align="center">KES {{$item->total}} </td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<table width="100%" style=" padding:0 10px 0 10px;">
    <tr>
        <td align="right" >
            <h2><span style="color: midnightblue;">Subtotal: </span>KES {{$order->sub_total}}</h2>
            <h3><span style="color: midnightblue;">Tax: </span>KES {{$order->vat}}</h3>
            <h2><span style="color: midnightblue;">Total: </span>KES {{$order->total}} </h2>
            {{-- <h2><span style="color: green;">Full Payment PAID</h2> --}}
        </td>
    </tr>
</table>
<div class="thanks mt-3">
    <p>Thanks For Buying Our Products..!!</p>
</div>
<div class="authority float-right mt-5">
    <p>-----------------------------------</p>
    <h5>Authority Signature:</h5>
</div>
</body>
</html>

