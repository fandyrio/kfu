
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>

                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group">
                        <a class="btn" href="#"><i class="icon-speech"></i></a>
                        <a class="btn" href="./"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                        <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
                    </div>
                </li>
            </ol>


            <div class="container-fluid">


                <div class="animated fadeIn">

                     <div class="card">
                                <div class="card-header">
                                    Traffic
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="callout callout-info">
                                                        <small class="text-muted">Jumlah User Login</small>
                                                        <br><strong class="h4">
                                                        <?php
                                                        $sql= pg_num_rows(pg_query($dbconn,"select * from auth_users where status_login='Y'"));

                                                        echo $sql;

                                                        ?></strong>
                                                        <div class="chart-wrapper">
                                                            <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/.col-->
                                                <div class="col-sm-6">
                                                    <div class="callout callout-danger">
                                                        <small class="text-muted">Pasien Rawat Jalan</small>
                                                        <br>
                                                        <strong class="h4"> <?php
                                                        $sql= pg_num_rows(pg_query($dbconn,"select * from antrian where id_jenis_kunjungan='1'"));

                                                        echo $sql;

                                                        ?></strong>
                                                        <div class="chart-wrapper">
                                                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/.col-->
                                            </div>
                                           
                                            
                                        </div>
                                        <!--/.col-->
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="callout callout-warning">
                                                        <small class="text-muted">Temu Hari Ini</small>
                                                        <br>
                                                        <strong class="h4"> <?php
                                                        $waktu = date('Y-m-d');
                                                        $sql= pg_num_rows(pg_query($dbconn,"select * from kunjungan where status_kunjungan='Y' and waktu_input like '$waktu%' "));
                                                        echo $sql;

                                                        ?></strong>
                                                        <div class="chart-wrapper">
                                                            <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/.col-->
                                                <div class="col-sm-6">
                                                    <div class="callout callout-success">
                                                        <small class="text-muted">Lab Order</small>
                                                        <br>
                                                        <strong class="h4"><?php
                                                        $sql= pg_num_rows(pg_query($dbconn,"select * from pasien_laborder "));

                                                        echo $sql;

                                                        ?></strong>
                                                        <div class="chart-wrapper">
                                                            <canvas id="sparkline-chart-4" width="100" height="30"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/.col-->
                                            </div>
                                    
                                        </div>
                                        <!--/.col-->
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="callout">
                                                        <small class="text-muted">Lab Order Terjawab</small>
                                                        <br>
                                                        <strong class="h4"><?php
                                                        $sql= pg_num_rows(pg_query($dbconn,"select * from pasien_laborder where status_jawab='Y' "));

                                                        echo $sql;

                                                        ?></strong>
                                                        <div class="chart-wrapper">
                                                            <canvas id="sparkline-chart-5" width="100" height="30"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                            </div>
                         
                                        </div>

                                 
                                        <div class="card-body">
                                            <div class="chart-wrapper">
                                                <canvas id="canvas"></canvas>
                                            </div>
                                        </div>
                                        <!--/.col-->
                                    </div>
                                    <!--/.row-->
                                    <br>
                                    
                                </div>
                            </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="social-box facebook">
                                <i class="fa fa-facebook"></i>
                                <div class="chart-wrapper">
                                    <canvas id="social-box-chart-1" height="90"></canvas>
                                </div>
                                <ul>
                                    <li>
                                        <strong>89k</strong>
                                        <span>friends</span>
                                    </li>
                                    <li>
                                        <strong>459</strong>
                                        <span>feeds</span>
                                    </li>
                                </ul>
                            </div>
                            <!--/.social-box-->
                        </div>
                        <!--/.col-->

                        <div class="col-sm-6 col-lg-3">
                            <div class="social-box twitter">
                                <i class="fa fa-twitter"></i>
                                <div class="chart-wrapper">
                                    <canvas id="social-box-chart-2" height="90"></canvas>
                                </div>
                                <ul>
                                    <li>
                                        <strong>973k</strong>
                                        <span>followers</span>
                                    </li>
                                    <li>
                                        <strong>1.792</strong>
                                        <span>tweets</span>
                                    </li>
                                </ul>
                            </div>
                            <!--/.social-box-->
                        </div>
                        <!--/.col-->

                        <div class="col-sm-6 col-lg-3">

                            <div class="social-box linkedin">
                                <i class="fa fa-linkedin"></i>
                                <div class="chart-wrapper">
                                    <canvas id="social-box-chart-3" height="90"></canvas>
                                </div>
                                <ul>
                                    <li>
                                        <strong>500+</strong>
                                        <span>contacts</span>
                                    </li>
                                    <li>
                                        <strong>292</strong>
                                        <span>feeds</span>
                                    </li>
                                </ul>
                            </div>
                            <!--/.social-box-->
                        </div>
                        <!--/.col-->

                        <div class="col-sm-6 col-lg-3">
                            <div class="social-box google-plus">
                                <i class="fa fa-google-plus"></i>
                                <div class="chart-wrapper">
                                    <canvas id="social-box-chart-4" height="90"></canvas>
                                </div>
                                <ul>
                                    <li>
                                        <strong>894</strong>
                                        <span>followers</span>
                                    </li>
                                    <li>
                                        <strong>92</strong>
                                        <span>circles</span>
                                    </li>
                                </ul>
                            </div>
                            <!--/.social-box-->
                        </div>
                        <!--/.col-->
                    </div>
                    <!--/.row-->

               
                    <!--/.row-->
                </div>


            </div>

    <script>
        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        
        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
            //return 0;
        };
        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function(opacity) {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
        };

        var config = {
            type: 'line',
            data: {
                labels: [
                <?php
                    $sql= pg_query($dbconn,"
                                SELECT waktu_input::date, 
                                       count(waktu_input) as jumlah                               
                                FROM kunjungan
                                GROUP BY waktu_input::date ");
                    $row_cnt = pg_num_rows($sql);
                    $i=1;
                    while($dataSelect=pg_fetch_array($sql))
                    {
                        if($row_cnt==$i){
                            echo "'".$dataSelect['waktu_input']."'";
                        }else {
                        echo "'".$dataSelect['waktu_input']."'".",";
                        }
                        $i++;
                    }
                    ?>
                ],
                datasets: [{
                    label: <?php
                    echo "' '";
                    ?>,
                    data: [
                            <?php

                    $sql= pg_query($dbconn," SELECT waktu_input::date, 
                                       count(waktu_input) as jumlah
                                      
                                FROM kunjungan
                                GROUP BY waktu_input::date  ");
                    $row_cnt = pg_num_rows($sql);       
                    $i=1;
                    while($dataSelect=pg_fetch_assoc($sql)){
                        if($row_cnt==$i){
                            echo "'".$dataSelect['jumlah']."'";
                        }else {
                        echo "'".$dataSelect['jumlah']."'".",";
                        }
                        $i++;
                    }
                    ?>
                            
                    ],
                  
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Kunjungan'
                },
                tooltips: {
                    mode: 'label',
                    callbacks: {
                        // beforeTitle: function() {
                        //     return '...beforeTitle';
                        // },
                        // afterTitle: function() {
                        //     return '...afterTitle';
                        // },
                        // beforeBody: function() {
                        //     return '...beforeBody';
                        // },
                        // afterBody: function() {
                        //     return '...afterBody';
                        // },
                        // beforeFooter: function() {
                        //     return '...beforeFooter';
                        // },
                        // footer: function() {
                        //     return 'Footer';
                        // },
                        // afterFooter: function() {
                        //     return '...afterFooter';
                        // },
                    }
                },
                hover: {
                    mode: 'dataset'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Tanggal/Jam'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Kunjungan '
                        },
                        
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 10,
                             fontColor: "red",
                        }
                    }]
                }
            }
        };

        $.each(config.data.datasets, function(i, dataset) {
            //alert(config.options.);
            alert(config.options.scales.yAxes.suggestedMax);
            if(dataset.data==200){
                fontColor: "green";
            alert(dataset.data);
            }else{
            dataset.borderColor = randomColor(0.4);
            dataset.backgroundColor ='rgba(75,139,245,0.4)';
            dataset.pointBorderColor = randomColor(0.7);
            dataset.pointBackgroundColor = randomColor(0.5);
            dataset.pointBorderWidth = 1;
                
            }
           
        });

        window.onload = function() {
            //var ctx = document.getElementById("canvas").getContext("2d");
            var ctx = $("#canvas").get(0).getContext("2d");
            window.myLine = new Chart(ctx, config);
        };

        $('#randomizeData').click(function() {
            $.each(config.data.datasets, function(i, dataset) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor();
                });

            });

            window.myLine.update();
        });

        
    </script>            