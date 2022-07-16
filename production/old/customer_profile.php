<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Customer Profile</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>ABC Vet (Pvt) Ltd.</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <img class="img-responsive img-thumbnail avatar-view" src="images/picture.jpg" alt="Avatar" title="Change the avatar">
                                </div>
                            </div>
                            <h3>ABC Vet (Pvt) Ltd. </h3>

                            <ul class="list-unstyled user_data">
                                <li><i class="fa fa-map-marker user-profile-icon"></i> No.56, Colombo Rd Minuwangoda.</li>
                            </ul>
                            <div class="tile-stats">
                                <h2 class="col-sm-12"><b>Rs.8179546.00</b></h2>
                                <h3>Total Purchases</h3>
                                <p>Lorem ipsum psdea itgum rixt.</p>
                            </div>
                            <div class="tile-stats">
                                <h2 class="col-sm-12"><b>Rs.1500.00</b></h2>
                                <h3>Outstandings</h3>
                                <p>Lorem ipsum psdea itgum rixt.</p>
                            </div>

                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Send Message<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" >
                                    <div class="form-group">
                                        <label>Method</label>
                                        <select class="form-control" id="input1">
                                            <option disabled="" value="0">Select Method</option>
                                            <option value="1">Emal</option>
                                            <option value="2">Mobile Number</option>
                                            <option value="2">Web</option>
                                        </select>
                                    </div>
                                    <div class="form-group" >
                                        <label>Message</label>
                                        <textarea style="min-height: 150px" class="form-control" placeholder="Enter Message" id="txtName"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-block btn-success"><i class="fa fa-send"></i> Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Overview</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Outstandings</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Messages</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Total Prduct purchases <small></small></h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div id="graph_bar1" style="width:100%; height:280px;"></div>
                                            </div>
                                        </div>
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Total Purchases <small>Sessions</small></h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content2">
                                                <div id="graph_line1" style="width:100%; height:300px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <table id="datatable-fixed-header" class="table table-striped table-bordered dt-button-collection nowrap" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice</th>
                                                        <th>Date & Time</th>
                                                        <th>User</th>
                                                        <th>Status</th>
                                                        <th>Amount(LKR)</th>
                                                        <th>Outstanding(LKR)</th>
                                                        <th class="col-sm-2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                                        <td>09:56 - 12/05/2017</td>
                                                        <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                                        <td>Pending</td>
                                                        <td>56000.00</td>
                                                        <td>6000.00</td>
                                                        <td>
                                                            <div>
                                                                <a href="invoice_prev.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                                        <td>09:56 - 12/05/2017</td>
                                                        <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                                        <td>Pending</td>
                                                        <td>56000.00</td>
                                                        <td>6000.00</td>
                                                        <td>
                                                            <div>
                                                                <a href="invoice_prev.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                                        <td>09:56 - 12/05/2017</td>
                                                        <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                                        <td>Pending</td>
                                                        <td>56000.00</td>
                                                        <td>6000.00</td>
                                                        <td>
                                                            <div>
                                                                <a href="invoice_prev.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                                        <td>09:56 - 12/05/2017</td>
                                                        <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                                        <td>Pending</td>
                                                        <td>56000.00</td>
                                                        <td>6000.00</td>
                                                        <td>
                                                            <div>
                                                                <a href="invoice_prev.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                                        <td>09:56 - 12/05/2017</td>
                                                        <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                                        <td>Pending</td>
                                                        <td>56000.00</td>
                                                        <td>6000.00</td>
                                                        <td>
                                                            <div>
                                                                <a href="invoice_prev.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                                        <td>09:56 - 12/05/2017</td>
                                                        <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                                        <td>Pending</td>
                                                        <td>56000.00</td>
                                                        <td>6000.00</td>
                                                        <td>
                                                            <div>
                                                                <a href="invoice_prev.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                                        <td>09:56 - 12/05/2017</td>
                                                        <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                                        <td>Pending</td>
                                                        <td>56000.00</td>
                                                        <td>6000.00</td>
                                                        <td>
                                                            <div>
                                                                <a href="invoice_prev.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                        <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
                                            photo booth letterpress, commodo enim craft beer mlkshk </p>
                                    </div>
                                </div>
                            </div>
                        </div>











                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<?php include './common/bottom_content.php'; ?><!-- bottom content -->
<script>
    if ($('#graph_bar1').length) {
        Morris.Bar({
            element: 'graph_bar1',
            data: [
                {device: 'iPhone 4', geekbench: 380},
                {device: 'iPhone 4S', geekbench: 655},
                {device: 'iPhone 3GS', geekbench: 275},
                {device: 'iPhone 5', geekbench: 1571},
                {device: 'iPhone 5S', geekbench: 655},
                {device: 'iPhone 6', geekbench: 2154},
                {device: 'iPhone 6 Plus', geekbench: 1144},
                {device: 'iPhone 6S', geekbench: 2371},
                {device: 'iPhone 6S Plus', geekbench: 1471},
                {device: 'Other', geekbench: 1371}
            ],
            xkey: 'device',
            ykeys: ['geekbench'],
            labels: ['Geekbench'],
            barRatio: 0.4,
            barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
            xLabelAngle: 35,
            hideHover: 'auto',
            resize: true
        });

        if ($('#graph_line1').length) {

            Morris.Line({
                element: 'graph_line1',
                xkey: 'year',
                ykeys: ['value'],
                labels: ['Value'],
                hideHover: 'auto',
                lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                data: [
                    {year: '2012', value: 20},
                    {year: '2013', value: 10},
                    {year: '2014', value: 5},
                    {year: '2015', value: 5},
                    {year: '2016', value: 20}
                ],
                resize: true
            });

            $MENU_TOGGLE.on('click', function () {
                $(window).resize();
            });

        }
    }
</script>