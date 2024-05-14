
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-editable-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    @vite('resources/js/app.js')
    <title>Point of sale</title>
</head>
<body>
<!-- ============================== MAIN SECTION START ============================== -->
<section id="mainSection">
    <div class="row mx-0">
        <!-- ============================== CALCULATION AREA START ============================== -->
        <div class="col-xl-6 px-1">
            <div class="top-area-btns d-xl-none">
                <div class="show-on-mob text-center">
                    <a href="#calculationArea" class="btn btn-green active-btn" type="button"><i class="fa fa-shopping-cart"></i> Cart</a>
                    <a href="#productArea" class="btn btn-green" type="button"><i class="fa fa-shopping-bag"></i> Product</a>
                </div>
                <div class="right-part">
                    <button class="btn btn-green" type="button" data-toggle="modal" data-target="#allSaleModal"><i class="fa fa-history"></i> <span>Your all sales</span></button>
                    <button class="btn btn-green" type="button"><i class="fa fa-tachometer"></i> <span>Dashboard</span></button>
                    <button class="btn btn-green" type="button"><i class="fa fa-sign-out"></i> <span>Logout</span></button>
                </div>
            </div>
            <div id="calculationArea" class="calculation-area">
                <div class="top-area">
                    <div class="input-group">
                        <select class="form-control" id="editable-select" placeholder="Select employee">
                            <option>Aprilia</option>
                            <option>Ktm</option>
                            <option>MVagusta</option>
                            <option>Ducati</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <select class="form-control" id="editable-select" placeholder="Walk-in customer">
                            <option>Ford</option>
                            <option>Land Rover</option>
                            <option>Mclarn</option>
                            <option>Volkwagen</option>
                            <option>Lamborghini</option>
                            <option>Bugatti</option>
                            <option>Nissan</option>
                            <option>Tesla</option>
                        </select>
                    </div>
                    <div class="edit-icon">
                        <button class="btn fa-btn" type="button" data-toggle="modal" data-target="#editCustomer"><i class="fa fa-pencil"></i></button>
                        <button class="btn fa-btn" type="button" data-toggle="modal" data-target="#addCustomer"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                    <cart />
                <div class="calculator">
                    <div class="displayBox">
                        <p class="displayText" id="display">0</p>
                    </div>
                    <table>
                        <tr>
                            <td><button class="btn clear hvr-back-pulse" id="clear">C</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="sqrt">√</button></td>
                            <td><button class="btn btn-calc hvr-radial-out hvr-radial-out" id="square">x<sup>2</sup></button></td>
                            <td><button id="divide" class="btn btn-operation hvr-fade">÷</button></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-calc hvr-radial-out" id="seven">7</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="eight">8</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="nine">9</button></td>
                            <td><button id="multiply" class="btn btn-operation hvr-fade">×</button></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-calc hvr-radial-out" id="four">4</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="five">5</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="six">6</button></td>
                            <td><button id="subtract" class="btn btn-operation hvr-fade">−</button></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-calc hvr-radial-out" id="one">1</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="two">2</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="three">3</button></td>
                            <td><button id="add" class="btn btn-operation hvr-fade">+</button></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-calc hvr-radial-out" id="zero">0</button></td>
                            <td><button class="btn btn-calc hvr-radial-out" id="decimal">.</button></td>
                            <td class="equal"><button id="equals" class="btn btn-operation equals hvr-back-pulse">=</button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="bottom-area-btns">
                <button class="btn btn-1 calculator-btn" type="button"><i class="fa fa-calculator"></i> Calculator</button>
                <button class="btn btn-green" type="button" data-toggle="modal" data-target="#"><i class="fa fa-keyboard-o"></i> Keyboard</button>
                <button class="btn btn-3" type="button" data-toggle="modal" data-target="#holdSaleModal"><i class="fa fa-folder-open"></i> Hold Sales</button>
                <button class="btn btn-4" type="button" data-toggle="modal" data-target="#"><i class="fa fa-times-circle"></i> Cancel</button>
                <button class="btn btn-yellow" type="button" data-toggle="modal" data-target="#holdBox"><i class="fa fa-hand-rock-o"></i> Hold</button>
                <button class="btn btn-6" type="button" data-toggle="modal" data-target="#paymentModal"><i class="fa fa-credit-card"></i> Payment</button>
                <button class="btn btn-7" type="button" data-toggle="modal" data-target="#holdBox"><i class="fa fa-hand-rock-o"></i> Hold</button>
            </div>
        </div>
        <!-- ============================== PRODUCT AREA START ============================== -->

    </div>
</section>
<!--==========================================================================-->
<div class="modal fade" id="exampleModal" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Add to cart</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== EDIT MODAL ============================== -->
<div class="modal fade" id="editModal" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Save changes</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== CUSTOMER MODAL ============================== -->
<div class="modal fade" id="addCustomer" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add customer</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phone:</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Father's name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Previous due:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Date of birth:</label>
                            <input type="text" class="form-control datepicker" placeholder="DD-MM-YYYY">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Group:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Delivery address:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Save changes</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== EDIT CUSTOMER MODAL ============================== -->
<div class="modal fade" id="editCustomer" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit customer</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phone:</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Father's name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Previous due:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Date of birth:</label>
                            <input type="text" class="form-control datepicker" placeholder="DD-MM-YYYY">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Group:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Delivery address:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Save changes</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== PRODUCT ADD MODAL ============================== -->
</div>
<!-- ============================== ALERT BOX MODAL ============================== -->
<div class="modal fade text-center" id="alertBox" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alert!</h4>
            </div>
            <div class="modal-body">
                <span>Modal body text goes here.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mx-auto" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== TYPE A NOTe MODAL ============================== -->
<div class="modal fade text-center" id="typeNoteBox" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Type a note!</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" placeholder="Write a note">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btns mx-auto">
                    <button type="button" class="btn">OK</button>
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================== PAYMENT HOLD MODAL ============================== -->
<div class="modal fade text-center" id="holdBox" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hold!</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" placeholder="Hold number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btns mx-auto">
                    <button type="button" class="btn">Submit</button>
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================== ADD ITEM MODAL ============================== -->
<div class="modal fade" id="addItemBox" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add item</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Product type:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Name:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Sale price:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Purchase price:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Whole sale price:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Opening stock:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Category:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Code:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Supplier:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Purchase unit:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Sale unit:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Conversion rate:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Brand:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Usual sale Qty/Amt:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Low Qty/Amt:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Warranty:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Guarantee:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Description:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Add item</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== PAYMENT MODAL ============================== -->
<div class="modal fade" id="paymentModal" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Complete payment</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="part1">
                    <p>Previous due <span>tk 7.00</span></p>
                    <p>Grand total <span>tk 7.00</span></p>
                    <p>Total payable <span>tk 7.00</span></p>
                </div>
                <hr>
                <form>
                    <div class="part2">
                        <div class="form-row">
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Paid amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Due amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Paid amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Due amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="part3">
                        <div class="form-row mx-0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Send invoice via sms</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck12">
                                <label class="form-check-label" for="exampleCheck12">Send invoice via email</label>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group col-12 mb-0">
                                <label for="">IMEI</label>
                                <textarea class="form-control" rows="2" cols="20"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Add to cart</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== HOLD SALE MODAL ============================== -->
<div class="modal fade" id="holdSaleModal" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hold sale</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 hold-sale-table">
                        <table class="table table01 mb-lg-0">
                            <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2020</td>
                            </tr>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2020</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-7 hold-sale-details">
                        <h5 class="text-center">Sale details</h5>
                        <p class="my-3"><b>Customer:</b> Walk-in-customer</p>
                        <table class="table table02 mb-0">
                            <thead class="">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty/Amt</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row">
                                <td>AMD Ryzen 5 3600 Processor</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            <tr class="table-row">
                                <td>AMD Ryzen 5 3600 Processor</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="sec-final-calculation">
                            <table class="table mb-0">
                                <tbody>
                                <tr class="table-row">
                                    <td>Total Item: <span>0</span></td>
                                    <td>Sub Total</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Shipping/Other</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Payable</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Paid amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Due amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-5 px-0 pr-lg-3 mb-3 mb-lg-0">
                        <button type="button" class="btn">Delete all hold sales</button>
                    </div>
                    <div class="col-lg-7 px-0 pl-lg-3">
                        <div class="bottom-area-btns text-center">
                            <button type="button" class="btn">Edit in cart</button>
                            <button type="button" class="btn">Delete</button>
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================== YOUR ALL SALES MODAL ============================== -->
<div class="modal fade" id="allSaleModal" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Your all sales</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 hold-sale-table">
                        <form action="">
                            <div class="form-row account mb-3">
                                <div class="col-6">
                                    <input type="text" class="form-control datepicker2" id="" placeholder="Select date">
                                </div>
                                <div class="col-6">
                                    <select class="form-control" id="editable-select" placeholder="Cash">
                                        <option>Cash</option>
                                        <option>Ktm</option>
                                        <option>MVagusta</option>
                                        <option>Ducati</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <table class="table table01 mb-lg-0">
                            <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2020</td>
                            </tr>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2021</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-7 hold-sale-details">
                        <form>
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Barcode">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </form>
                        <h5 class="text-center">Sale details</h5>
                        <p class="mt-3"><b>Invoice no:</b> <span>000289</span></p>
                        <p class="mb-3"><b>Customer:</b> <span>Walk-in-customer</span></p>
                        <table class="table table02 mb-0">
                            <thead class="">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty/Amt</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row">
                                <td>AMD Ryzen 5 3600 Processor</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            <tr class="table-row">
                                <td>AMD Ryzen 5 3600 Processor</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="sec-final-calculation">
                            <table class="table mb-0">
                                <tbody>
                                <tr class="table-row">
                                    <td>Total Item: <span>0</span></td>
                                    <td>Sub Total</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Shipping/Other</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Payable</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Paid amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Due amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-5 px-0 pr-lg-3 mb-3 mb-lg-0">
                    </div>
                    <div class="col-lg-7 px-0 pl-lg-3">
                        <div class="bottom-area-btns">
                            <button type="button" class="btn">Print invoice</button>
                            <button type="button" class="btn">Delete</button>
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- ============================== MAIN SECTION START ============================== -->
<section id="mainSection">
    <div id="app">
    <div class="row mx-0">
        <!-- ============================== CALCULATION AREA START ============================== -->

        <carts></carts>

        <!-- ============================== PRODUCT AREA START ============================== -->
        <div id="productArea" class="col-xl-6 px-1">
            <div class="top-area-btns d-none d-xl-block">
                <div class="right-part">
                    <button class="btn btn-green" type="button" data-toggle="modal" data-target="#allSaleModal">
                        <i class="fa fa-history"></i> <span>Your all sales</span>
                    </button>
                    <button class="btn btn-green" type="button">
                        <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                    </button>
                    <button class="btn btn-green" type="button">
                        <i class="fa fa-sign-out"></i> <span>Logout</span>
                    </button>
                </div>
            </div>
            <products></products>
        </div>
    </div>
    </div>
</section>

<!--==========================================================================-->
<div class="modal fade" id="exampleModal" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Add to cart</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== EDIT MODAL ============================== -->
<div class="modal fade" id="editModal" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Save changes</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== CUSTOMER MODAL ============================== -->
<div class="modal fade" id="addCustomer" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add customer</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phone:</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Father's name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Previous due:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Date of birth:</label>
                            <input type="text" class="form-control datepicker" placeholder="DD-MM-YYYY">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Group:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Delivery address:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Save changes</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== EDIT CUSTOMER MODAL ============================== -->
<div class="modal fade" id="editCustomer" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit customer</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phone:</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Father's name:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email:</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Previous due:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Date of birth:</label>
                            <input type="text" class="form-control datepicker" placeholder="DD-MM-YYYY">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Group:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Delivery address:</label>
                            <input type="email" class="form-control" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Save changes</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ============================== ALERT BOX MODAL ============================== -->
<div class="modal fade text-center" id="alertBox" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alert!</h4>
            </div>
            <div class="modal-body">
                <span>Modal body text goes here.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mx-auto" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== TYPE A NOTe MODAL ============================== -->
<div class="modal fade text-center" id="typeNoteBox" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Type a note!</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" placeholder="Write a note">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btns mx-auto">
                    <button type="button" class="btn">OK</button>
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================== PAYMENT HOLD MODAL ============================== -->
<div class="modal fade text-center" id="holdBox" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hold!</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" placeholder="Hold number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btns mx-auto">
                    <button type="button" class="btn">Submit</button>
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================== ADD ITEM MODAL ============================== -->
<div class="modal fade" id="addItemBox" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add item</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Product type:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Name:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Sale price:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Purchase price:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Whole sale price:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Opening stock:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Category:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Code:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Supplier:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Purchase unit:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Sale unit:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Conversion rate:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Brand:</label>
                            <select class="form-control" id="editable-select">
                                <option selected>Aprilia</option>
                                <option>Ktm</option>
                                <option>MVagusta</option>
                                <option>Ducati</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Usual sale Qty/Amt:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Low Qty/Amt:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Warranty:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Guarantee:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="">Description:</label>
                            <input type="" class="form-control" placeholder="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Add item</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== PAYMENT MODAL ============================== -->
<div class="modal fade" id="paymentModal" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Complete payment</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="part1">
                    <p>Previous due <span>tk 7.00</span></p>
                    <p>Grand total <span>tk 7.00</span></p>
                    <p>Total payable <span>tk 7.00</span></p>
                </div>
                <hr>
                <form>
                    <div class="part2">
                        <div class="form-row">
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Paid amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Due amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Paid amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-6 col-lg-3">
                                <label for="">Due amount:</label>
                                <input type="" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="part3">
                        <div class="form-row mx-0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Send invoice via sms</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck12">
                                <label class="form-check-label" for="exampleCheck12">Send invoice via email</label>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group col-12 mb-0">
                                <label for="">IMEI</label>
                                <textarea class="form-control" rows="2" cols="20"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn">Add to cart</button>
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================== HOLD SALE MODAL ============================== -->
<div class="modal fade" id="holdSaleModal" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hold sale</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 hold-sale-table">
                        <table class="table table01 mb-lg-0">
                            <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2020</td>
                            </tr>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2020</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-7 hold-sale-details">
                        <h5 class="text-center">Sale details</h5>
                        <p class="my-3"><b>Customer:</b> Walk-in-customer</p>
                        <table class="table table02 mb-0">
                            <thead class="">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty/Amt</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row">
                                <td>AMD Ryzen 5 3600 Processor</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            <tr class="table-row">
                                <td>AMD Ryzen 5 3600 Processor</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="sec-final-calculation">
                            <table class="table mb-0">
                                <tbody>
                                <tr class="table-row">
                                    <td>Total Item: <span>0</span></td>
                                    <td>Sub Total</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Shipping/Other</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Payable</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Paid amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Due amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-5 px-0 pr-lg-3 mb-3 mb-lg-0">
                        <button type="button" class="btn">Delete all hold sales</button>
                    </div>
                    <div class="col-lg-7 px-0 pl-lg-3">
                        <div class="bottom-area-btns text-center">
                            <button type="button" class="btn">Edit in cart</button>
                            <button type="button" class="btn">Delete</button>
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================== YOUR ALL SALES MODAL ============================== -->
<div class="modal fade" id="allSaleModal" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Your all sales</h4>
                <button type="button" class="btn close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 hold-sale-table">
                        <form action="">
                            <div class="form-row account mb-3">
                                <div class="col-6">
                                    <input type="text" class="form-control datepicker2" id="" placeholder="Select date">
                                </div>
                                <div class="col-6">
                                    <select class="form-control" id="editable-select" placeholder="Cash">
                                        <option>Cash</option>
                                        <option>Ktm</option>
                                        <option>MVagusta</option>
                                        <option>Ducati</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <table class="table table01 mb-lg-0">
                            <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2020</td>
                            </tr>
                            <tr class="table-row" type="button">
                                <td>1</td>
                                <td>Walk-in customer</td>
                                <td>31-12-2021</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-7 hold-sale-details">
                        <form>
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Barcode">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </form>
                        <h5 class="text-center">Sale details</h5>
                        <p class="mt-3"><b>Invoice no:</b> <span>000289</span></p>
                        <p class="mb-3"><b>Customer:</b> <span>Walk-in-customer</span></p>
                        <table class="table table02 mb-0">
                            <thead class="">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty/Amt</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="table-row">
                                <td>Ryzen 5 3600 Processor33</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            <tr class="table-row">
                                <td>Ryzen 5 3600 Processor22</td>
                                <td>16,800 tk</td>
                                <td>10 kg</td>
                                <td>10%</td>
                                <td>15,120</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="sec-final-calculation">
                            <table class="table mb-0">
                                <tbody>
                                <tr class="table-row">
                                    <td>Total Item: <span>0</span></td>
                                    <td>Sub Total</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Discount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Shipping/Other</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Total Payable</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Paid amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                <tr class="table-row">
                                    <td></td>
                                    <td>Due amount</td>
                                    <td>tk <span>0.00</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-5 px-0 pr-lg-3 mb-3 mb-lg-0">
                    </div>
                    <div class="col-lg-7 px-0 pl-lg-3">
                        <div class="bottom-area-btns">
                            <button type="button" class="btn">Print invoice</button>
                            <button type="button" class="btn">Delete</button>
                            <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-editable-select.min.js')}}"></script>
<script src="{{asset('assets/js/calculate.js')}}"></script>
<script src="{{asset('assets/js/style.js')}}"></script>
<script type="text/javascript">

    function increaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('number').value = value;
    }

    function decreaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        document.getElementById('number').value = value;
    }

</script>
</body>
</html>
