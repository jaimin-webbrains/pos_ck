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
                                    <!-- Current avatar -->
                                    <img class="img-responsive avatar-view" src="images/picture.jpg" alt="Avatar" title="Change the avatar">
                                </div>
                            </div>
                            <h3>Muditha Priyanka</h3>
                            <ul class="list-unstyled user_data">
                                <li><i class="fa fa-user-circle user-profile-icon"></i> miditha</li>
                                <li><i class="fa fa-id-card user-profile-icon"></i> 926546546v</li>
                                <li><i class="fa fa-envelope user-profile-icon"></i> muditha@gmail.com</li>
                                <li><i class="fa fa-phone user-profile-icon"></i> 0774654656</li>
                                <li><i class="fa fa-map-marker user-profile-icon"></i> San Francisco, California, USA</li>
                                <li><i class="fa fa-briefcase user-profile-icon"></i> Software Engineer</li>
                                <li><i class="fa fa-group user-profile-icon"></i> Roles
                                    <ul class=" user_data">
                                        <li>Rep</li>
                                        <li>Deliverer</li>
                                    </ul>
                                </li>
                            </ul>

                            <!--<button id="btnNew" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-edit"></i> Edit Profile</button>-->
                            <br />
                            
                            <div class="tile-stats">
                                <h2 class="col-sm-12"><b>Comition</b></h2>
                                <h3>Rs.8179546.00</h3>
                            </div>

                            <!-- start skills -->
                            <h4>Targets</h4>
                            <ul class="list-unstyled user_data">
                                <li>
                                    <p>Web Applications</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>Website Design</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>Automation & Testing</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>UI / UX</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                                    </div>
                                </li>
                            </ul>
                            <!-- end of skills -->

                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Bar Charts <small>Sessions</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="graph_bar1" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Line Graph <small>Sessions</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content2">
                                    <div id="graph_line1" style="width:100%; height:300px;"></div>
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