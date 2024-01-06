<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo $__env->make('admin.components.page-title',['title' => __($page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Dashboard")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-area">
        <div class="dashboard-item-area">
            <div class="row">
                <div class="col-xxxl-3 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title"><?php echo e(__("Add Money Balance")); ?></h6>
                                <div class="user-info">
                                    <h2 class="user-count"><?php echo e(get_default_currency_symbol()); ?><?php echo e(get_amount($data['add_money_balance'])); ?></h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">This Month <?php echo e(formatNumberInKNotation($data['today_add_money'])); ?></span>
                                    <span class="badge badge--warning">Last Month <?php echo e(formatNumberInKNotation($data['last_month_add_money'])); ?></span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart7" data-percent="<?php echo e($data['add_money_percent']); ?>"><span><?php echo e(round($data['add_money_percent'])); ?>%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-3 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">

                            <?php if(virtual_card_system('stripe')): ?>
                            <div class="left">
                                <h6 class="title"><?php echo e(__("Stripe Issuing Balance")); ?></h6>
                                <div class="user-info">

                                    <h2 class="user-count"><?php echo e(get_default_currency_symbol()); ?><?php echo e(getAmount(getIssueBalance()['amount'],2)); ?></h2>
                                </div>
                                <div class="user-badge">
                                    <?php if(getIssueBalance()['status'] == true): ?>
                                        <span class="badge badge--success"><?php echo e(getIssueBalance()['message']); ?></span>
                                    <?php else: ?>
                                    <span class="badge badge--danger"><?php echo e(getIssueBalance()['message']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="right">
                                <div class="chart" id="chart16" data-percent="100"><span>100%</span></div>
                            </div>
                        </div>

                    </div>
                </div>

                
                <div class="col-xxxl-3 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title"><?php echo e(__("Total Users")); ?></h6>
                                <div class="user-info">
                                    <h2 class="user-count"><?php echo e(formatNumberInKNotation($data['total_user'])); ?></h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info"><?php echo e(__("Active")); ?> <?php echo e($data['active_user']); ?></span>
                                    <span class="badge badge--warning"><?php echo e(__("Unverified")); ?> <?php echo e($data['unverified_user']); ?></span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart11" data-percent="<?php echo e($data['user_percent']); ?>"><span><?php echo e(round($data['user_percent'])); ?>%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-3 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title"><?php echo e(__("Pending Add Money")); ?></h6>
                                <div class="user-info">
                                    <h2 class="user-count"><?php echo e(get_default_currency_symbol()); ?><?php echo e(get_amount($data['pending_add_money_balance'])); ?></h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info"><?php echo e(__("This Month")); ?> <?php echo e(formatNumberInKNotation($data['today_pending_add_money'])); ?></span>
                                    <span class="badge badge--warning"><?php echo e(__("Last Month")); ?> <?php echo e(formatNumberInKNotation($data['last_month_pending_add_money'])); ?></span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart13" data-percent="<?php echo e($data['pending_add_money_percent']); ?>"><span><?php echo e(round($data['pending_add_money_percent'])); ?>%</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="chart-area mt-15">
        <div class="row mb-15-none">
            <div class="col-xxl-6 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title">
                           <?php echo e(__(" Monthly Add Money Chart")); ?>

                        </h5>
                        <a href="<?php echo e(setRoute('admin.add.money.index')); ?>" class="btn--base modal-btn"> <?php echo e(__("View")); ?></a>
                    </div>
                    <div class="chart-container">
                        <div id="chart1" data-chart_one_data="<?php echo e(json_encode($data['chart_one_data'])); ?>" data-month_day="<?php echo e(json_encode($data['month_day'])); ?>" class="sales-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title"><?php echo e(__("Monthly Virtual Card Chart")); ?></h5>
                        <a href="<?php echo e(setRoute('admin.virtual.card.logs')); ?>" class="btn--base modal-btn"> View</a>

                    </div>
                    <div class="chart-container">
                        <div id="chart2" data-chart_two_data="<?php echo e(json_encode($data['chart_two_data'])); ?>" class="revenue-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title"><?php echo e(__("Announcement Analytics")); ?></h5>
                        <div>
                            <a href="<?php echo e(url('/').'/admin/setup-sections/blog-section'); ?>" class="btn--base modal-btn"><?php echo e(__( "View Blogs")); ?></a>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div id="chart3"  data-chart_three_data="<?php echo e(json_encode($data['chart_three_data'])); ?>" class="order-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxxl-6 col-xxl-3 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title"><?php echo e(__("User Analytics")); ?></h5>
                    </div>
                    <div class="chart-container">
                        <div id="chart4" data-chart_four_data="<?php echo e(json_encode($data['chart_four_data'])); ?>" class="balance-chart"></div>
                    </div>
                    <div class="chart-area-footer">
                        <div class="chart-btn">
                            <a href="<?php echo e(setRoute('admin.users.index')); ?>" class="btn--base w-100"><?php echo e(__("View User")); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxxl-6 col-xxl-6 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title"><?php echo e(__("Add Money Growth")); ?></h5>
                    </div>
                    <div class="chart-container">
                        <div id="chart5" data-chart_five_data="<?php echo e(json_encode($data['chart_five_data'])); ?>" class="growth-chart"></div>
                    </div>
                    <div class="chart-area-footer">
                        <div class="chart-btn">
                            <a href="<?php echo e(setRoute('admin.add.money.index')); ?>" class="btn--base w-100"><?php echo e(__("View Add Money")); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-area  mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">Latest Add Money</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th><?php echo e(__("TRX")); ?></th>
                            <th><?php echo e(__("User")); ?></th>
                            
                            <th><?php echo e(__("Amount")); ?></th>
                            <th><?php echo e(__("Method")); ?></th>
                            <th><?php echo e(__(("Status"))); ?></th>
                            <th><?php echo e(__("Time")); ?></th>
                            <th><?php echo e(__("Action")); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $data['transactions'] ??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>
                                <td><?php echo e($item->trx_id); ?></td>
                                <td>
                                    <a href="<?php echo e(setRoute('admin.users.details',$item->user->username)); ?>"><span class="text-info"><?php echo e($item->user->fullname); ?></span></a>
                                </td>
                                

                                <td><?php echo e(number_format($item->request_amount,2)); ?> <?php echo e(get_default_currency_code()); ?></td>
                                <td><span class="text--info"><?php echo e($item->currency->name); ?></span></td>
                                <td>
                                    <span class="<?php echo e($item->stringStatus->class); ?>"><?php echo e($item->stringStatus->value); ?></span>
                                </td>
                                <td><?php echo e($item->created_at->format('d-m-y h:i:s A')); ?></td>
                                <td>
                                    <?php echo $__env->make('admin.components.link.info-default',[
                                        'href'          => setRoute('admin.add.money.details', $item->id),
                                        'permission'    => "admin.add.money.details",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="alert alert-primary"><?php echo e(__('No data found!')); ?></div>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
 <script>
    var chart1 = $('#chart1');
    var chart_one_data = chart1.data('chart_one_data');
    var month_day = chart1.data('month_day');
    // apex-chart
    var options = {
    series: [{
    name: 'Pending',
    color: "#5A5278",
    data: chart_one_data.pending_data
    }, {
    name: 'Completed',
    color: "#6F6593",
    data: chart_one_data.success_data
    }, {
    name: 'Canceled',
    color: "#8075AA",
    data: chart_one_data.canceled_data
    }, {
    name: 'Hold',
    color: "#A192D9",
    data: chart_one_data.hold_data
    }],
    chart: {
    type: 'bar',
    height: 350,
    stacked: true,
    toolbar: {
        show: false
    },
    zoom: {
        enabled: true
    }
    },
    responsive: [{
    breakpoint: 480,
    options: {
        legend: {
        position: 'bottom',
        offsetX: -10,
        offsetY: 0
        }
    }
    }],
    plotOptions: {
    bar: {
        horizontal: false,
        borderRadius: 10
    },
    },
    xaxis: {
    type: 'datetime',
    categories: month_day,
    },
    legend: {
    position: 'bottom',
    offsetX: 40
    },
    fill: {
    opacity: 1
    }
    };

    var chart = new ApexCharts(document.querySelector("#chart1"), options);
    chart.render()

    var chart2 = $('#chart2');
    var chart_two_data = chart2.data('chart_two_data');
    var options = {
    series: [{
    name: 'Pending',
    color: "#5A5278",
    data: chart_two_data.pending_data
    }, {
    name: 'Completed',
    color: "#6F6593",
    data: chart_two_data.success_data
    }, {
    name: 'Canceled',
    color: "#8075AA",
    data: chart_two_data.canceled_data
    }, {
    name: 'Hold',
    color: "#A192D9",
    data: chart_two_data.hold_data
    }],
    chart: {
    type: 'bar',
    height: 350,
    stacked: true,
    toolbar: {
        show: false
    },
    zoom: {
        enabled: true
    }
    },
    responsive: [{
    breakpoint: 480,
    options: {
        legend: {
        position: 'bottom',
        offsetX: -10,
        offsetY: 0
        }
    }
    }],
    plotOptions: {
    bar: {
        horizontal: true,
        borderRadius: 10
    },
    },
    yaxis: {
    type: 'datetime',
    labels: {
        format: 'dd/MMM',
    },
    categories: month_day,
    },
    legend: {
    position: 'bottom',
    offsetX: 40
    },
    fill: {
    opacity: 1
    }
    };

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();

    var chart3 = $('#chart3');
    var chart_three_data = chart3.data('chart_three_data');

    var options = {
    series: [
    {
        name: 'All',
        color: "#8075AA",
        data: chart_three_data.all_data
    },{
    name: 'Announcement',
    color: "#6F6593",
    data: chart_three_data.event
    }],
    chart: {
    type: 'bar',
    toolbar: {
        show: false
    },
    height: 325
    },
    plotOptions: {
    bar: {
        horizontal: false,
        columnWidth: '55%',
        borderRadius: 5,
        endingShape: 'rounded'
    },
    },
    dataLabels: {
    enabled: false
    },
    stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
    },
    xaxis: {
        type: 'datetime',
        categories: month_day,
    },
    fill: {
    opacity: 1
    },
    tooltip: {
    y: {
        formatter: function (val) {
        return val
        }
    }
    }
    };

    var chart = new ApexCharts(document.querySelector("#chart3"), options);
    chart.render();

    var chart4 = $('#chart4');
    var chart_four_data = chart4.data('chart_four_data');

    var options = {
    series: chart_four_data,
    chart: {
    width: 350,
    type: 'pie'
    },
    colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
    labels: ['Active', 'Unverified', 'Banned', 'All'],
    responsive: [{
    breakpoint: 1480,
    options: {
        chart: {
        width: 280
        },
        legend: {
        position: 'bottom'
        }
    },
    breakpoint: 1199,
    options: {
        chart: {
        width: 380
        },
        legend: {
        position: 'bottom'
        }
    },
    breakpoint: 575,
    options: {
        chart: {
        width: 280
        },
        legend: {
        position: 'bottom'
        }
    }
    }],
    legend: {
    position: 'bottom'
    },
    };

    var chart = new ApexCharts(document.querySelector("#chart4"), options);
    chart.render();

    var chart5 = $('#chart5');
    var chart_five_data = chart5.data('chart_five_data');
    console.log(chart_five_data);

    var options = {
    series: chart_five_data,
    chart: {
    width: 350,
    type: 'donut',
    },
    colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
    labels: ['Today', '1 week', '1 month', '1 year'],
    legend: {
        position: 'bottom'
    },
    responsive: [{
    breakpoint: 1600,
    options: {
        chart: {
        width: 100,
        },
        legend: {
        position: 'bottom'
        }
    },
    breakpoint: 1199,
    options: {
        chart: {
        width: 380
        },
        legend: {
        position: 'bottom'
        }
    },
    breakpoint: 575,
    options: {
        chart: {
        width: 280
        },
        legend: {
        position: 'bottom'
        }
    }
    }]
    };

    var chart = new ApexCharts(document.querySelector("#chart5"), options);
    chart.render();


    // pie-chart
    $(function() {
    $('#chart6').easyPieChart({
        size: 80,
        barColor: '#f05050',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#f050505a',
        lineCap: 'circle',
        animate: 3000
    });
    });

    $(function() {
    $('#chart7').easyPieChart({
        size: 80,
        barColor: '#10c469',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#10c4695a',
        lineCap: 'circle',
        animate: 3000
    });
    });

    $(function() {
    $('#chart8').easyPieChart({
        size: 80,
        barColor: '#ffbd4a',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#ffbd4a5a',
        lineCap: 'circle',
        animate: 3000
    });
    });

    $(function() {
    $('#chart9').easyPieChart({
        size: 80,
        barColor: '#ff8acc',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#ff8acc5a',
        lineCap: 'circle',
        animate: 3000
    });
    });

    $(function() {
    $('#chart10').easyPieChart({
        size: 80,
        barColor: '#7367f0',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#7367f05a',
        lineCap: 'circle',
        animate: 3000
    });
    });

    $(function() {
    $('#chart11').easyPieChart({
        size: 80,
        barColor: '#1e9ff2',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#1e9ff25a',
        lineCap: 'circle',
        animate: 3000
    });
    });

    $(function() {
    $('#chart12').easyPieChart({
        size: 80,
        barColor: '#5a5278',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#5a52785a',
        lineCap: 'circle',
        animate: 3000
    });
    });

    $(function() {
    $('#chart13').easyPieChart({
        size: 80,
        barColor: '#ADDDD0',
        scaleColor: false,
        lineWidth: 5,
        trackColor: '#ADDDD05a',
        lineCap: 'circle',
        animate: 3000
    });
    });
    $(function() {
    $('#chart16').easyPieChart({
            size: 80,
            barColor: '#10c469',
            scaleColor: false,
            lineWidth: 5,
            trackColor: '#10c4695a',
            lineCap: 'circle',
        animate: 3000
    });
    });

 </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\views/admin/sections/dashboard/index.blade.php ENDPATH**/ ?>