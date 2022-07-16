<?php include './common/upper_content.php'; ?><!-- upper content -->
<style>
    ul li{
        font-size: 15px;
        font-weight: bold;
        cursor:pointer;
    }
    ul li:hover {
        color: #000;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Invoice</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <!--<h2>Order</h2>-->
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="radio">
                                <label id="rdbOrder">
                                    <input type="radio" class="flat radios" checked name="iCheck" > Order vise Invoice
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="radio">
                                <label id="rdbCustomer">
                                    <input type="radio" class="flat radios" name="iCheck" > Customer vise Invoice
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="radio">
                                <label id="rdbRetailCustomer">
                                    <input type="radio" class="flat radios" name="iCheck" > Retail Customer Invoice
                                </label>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="divCOrder">
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label>Customer</label>
                                <input type="text" class="form-control" placeholder="Customer Name" id="txtCustomer">
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label>Orders</label>
                                <select class="form-control" id="cmbOrder">
                                    <option disabled="" value="0">Select Order</option>
                                    <option value="1">Order one</option>
                                    <option value="2">Order two</option>
                                    <option value="3">Order three</option>
                                    <option value="4">Order four</option>
                                </select>
                            </div>
                        </div>
                        <div id="divCCustomer">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label>Customer</label>
                                <input type="text" class="form-control" placeholder="Customer Name" id="txtCustomer">
                            </div>
                        </div>
                        <div id="divRetailCustomer">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>New Customer</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="form-group col-md-4 col-sm-4 col-xs-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Product Name" id="txtCostPrice">
                                    </div>
                                    <div class="form-group col-md-4 col-sm-4 col-xs-6">
                                        <label>Telephone</label>
                                        <input type="date" class="form-control" placeholder="Telephone" id="txtCTelephone">
                                    </div>
                                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                        <label>Email</label>
                                        <input type="date" class="form-control" placeholder="Email" id="txtCEmail">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <label>Address</label>
                                        <textarea class="form-control" placeholder="Email" id="txtCAddress"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Select Products</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 ">
                            <label>Product</label>
                            <!--<input type="text" class="form-control" placeholder="Search by Product Code" id="txtProduct">-->
                            <select class="form-control" id="cmbProducts">
                                <option disabled="" value="0" selected="">Select Product</option>
                                <option value="1">Product One</option>
                                <option value="2">Product Two</option>
                                <option value="3">Product Three</option>
                                <option value="4">Product Four</option>
                                <option value="5">Product Five</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 ">
                            <div class="container-fluid divBack">
                                <div class="form-group col-md-8 col-sm-8 col-xs-12">
                                    <label class="x_title washed" style="display: block;"><small>Product</small></label>
                                    <h4><strong id="lblProduct">Select Product...</strong></h4>
                                </div>
                                <div class="form-group col-md-2 col-sm-2 col-xs-6">
                                    <label class="x_title washed" style="display: block;"><small>Price</small></label>
                                    <h4><strong id="lblPrice"></strong></h4>
                                </div>
                                <div class="form-group col-md-2 col-sm-2 col-xs-6">
                                    <label class="x_title washed" style="display: block;"><small>Currunt Price</small></label>
                                    <h4><strong id="lblCurruntPrice"></strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="x_content">

                        <div class="form-group col-md-3 col-sm-5 col-xs-12">
                            <label>Quantity</label>
                            <input type="number" id="qty" name="number" required="required" min="1" max="5000" data-validate-minmax="1,5000" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="form-group col-md-3 col-sm-5 col-xs-12">
                            <label>Discount</label>
                            <input type="text" class="form-control" placeholder="Discount" id="txtDiscount">
                        </div>
                        <div class="form-group col-md-3 col-sm-2 col-xs-12">
                            <label>Total</label>
                            <!--<h4><strong id="lblTotal"></strong></h4>-->
                            <input type="text" class="form-control" placeholder="Total" disabled="" id="txtTotal">
                        </div>
                        <div class="form-group col-md-3 col-sm-2 col-xs-12">  
                            <label>Add</label>
                            <button id="btnAdd" type="button" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-menu-down"></i> Add</button>
                        </div>
                        <!--                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                    <button id="btnAdd" type="button" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-menu-down"></i> Add</button>
                                                </div>-->
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Invoice Products</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="tblInProducts" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Product code</th>
                                    <th>Quantity</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th class="col-sm-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Discount</label>
                            <input type="text" class="form-control" placeholder="Discount" id="txtFinalDiscount">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Total</label>
                            <input type="text" class="form-control" placeholder="Total" disabled="" id="txtFinalTotal">
                        </div>
                    </div>
                    <div class="x_content">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Cash</label>
                            <input type="text" class="form-control" placeholder="Cash" id="txtFinalDiscount">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label>Balance</label>
                            <input type="text" class="form-control" placeholder="Total" disabled="" id="txtFinalTotal">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save And Proceed</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<?php include './common/bottom_content.php'; ?><!-- bottom content -->
<script>
    
    window.onload = function () {
        $("#divCOrder").css({"display": "initial"});
        $("#divCCustomer").css({"display": "none"});
        $("#divRetailCustomer").css({"display": "none"});
    };
    
    $(function () {
        var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
        ];
        $("#txtCustomer").autocomplete({
            source: availableTags
        });
    });

    var product0 = {id: 0, name: "Product One", category: "Category One", price: 450.00, current_price: 400.00};
    var product1 = {id: 1, name: "Product One", category: "Category One", price: 450.00, current_price: 400.00};
    var product2 = {id: 2, name: "Product Two", category: "Category Four", price: 550.00, current_price: 500.00};
    var product3 = {id: 3, name: "Product Three", category: "Category Two", price: 600.00, current_price: 550.00};
    var product4 = {id: 4, name: "Product Four", category: "Category One", price: 200.00, current_price: 150.00};
    var product5 = {id: 5, name: "Product Five", category: "Category Four", price: 800.00, current_price: 750.00};

    var products = [product0, product1, product2, product3, product4, product5];

    var id;
    var price = 0;
    var total = 0;
    var discount = 0;
    var qty = 1;
    var final_discount = 0;
    var final_total = 0;
    var discounted_final_total = 0;

    $("#cmbProducts").change(function (e) {
        e.preventDefault;
        var temp_id = $("#cmbProducts").val();
        id = temp_id;
        fillProduct(id);
    });

    function fillProduct(id) {
        $("#lblProduct").text(products[id].name + " - " + products[id].category);
//        $("#lblCategory").text(products[id].category);
        $("#lblPrice").text(products[id].price);
        $("#lblCurruntPrice").text(products[id].current_price);
        price = products[id].current_price;
        total = price;
        discount = 0;
        qty = 1;

        $("#qty").val(qty);
        $("#txtTotal").val(total);
    }

    function calculateTotal() {
        discount = $("#txtDiscount").val();
        qty = $("#qty").val();
        total = (price * qty) - discount;
        $("#txtTotal").val(total);
    }

    $("#qty").change(function (e) {
        e.preventDefault;
        calculateTotal();
    });

    $("#txtDiscount").keyup(function (e) {
        e.preventDefault;
        calculateTotal();
    });

    $("#txtDiscount").change(function (e) {
        e.preventDefault;
        calculateTotal();
    });

    $("#btnAdd").click(function (e) {
        e.preventDefault;
        add();
    });

    $("#txtFinalDiscount").change(function (e) {
        e.preventDefault;
        final_discount = $("#txtFinalDiscount").val();
        calculate_final_total();
    });


    function reloadProduct() {
        $("#lblProduct").text("Select Product...");
//        $("#lblCategory").text("");
        $("#lblPrice").text("");
        $("#lblCurruntPrice").text("");
        $("#txtDiscount").val("");
        $("#qty").val(1);
        $("#txtTotal").val("");
        $("#cmbProducts").val(0);
        id = null;
        price = 0;
        total = 0;
        discount = 0;
        qty = 1;
    }

    function add() {
        if (id) {
            var button = "<button type='button' onclick='removeTourPlan(this)' class='btn btn-danger'><i class='glyphicon glyphicon-remove'></i></button>";
            generatedHTML = "<tr><td>" + products[id].name + "</td><td>" + products[id].category + "</td><td>" + qty + "</td><td>" + discount + "</td><td>" + total + "</td><td>" + button + "</td></tr>";
            $('#tblInProducts').append(generatedHTML);
            calculate_final_total();
            reloadProduct();
        }
    }

    function calculate_final_total() {
        final_total += total;
        discounted_final_total = (final_total - final_discount);
        $("#txtFinalTotal").val(discounted_final_total);
    }
    
    $("#rdbOrder").click(function (e) {
        e.preventDefault;
        loadUI(this.id);
    });
    $("#rdbCustomer").click(function (e) {
        e.preventDefault;
        loadUI(this.id);
    });
    $("#rdbRetailCustomer").click(function (e) {
        e.preventDefault;
        loadUI(this.id);
    });
    
    function loadUI(id){
        if(id=="rdbOrder"){
            $("#divCOrder").css({"display": "initial"});
            $("#divCCustomer").css({"display": "none"});
            $("#divRetailCustomer").css({"display": "none"});
        }
        if(id=="rdbCustomer"){
            $("#divCOrder").css({"display": "none"});
            $("#divCCustomer").css({"display": "initial"});
            $("#divRetailCustomer").css({"display": "none"});
        }
        if(id=="rdbRetailCustomer"){
            $("#divCOrder").css({"display": "none"});
            $("#divCCustomer").css({"display": "none"});
            $("#divRetailCustomer").css({"display": "initial"});
        }
    }

</script>