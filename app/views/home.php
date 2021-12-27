<div v-bind:class="[{ loading: loading }, 'content-section redemption-dashboard']" id="main_wrapper" v-cloak>
    <div class="container-fluid page-body-wrapper">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row no-gutters">
                    <div class="col-12 grid-margin ">
                        <div class="row">
                            <div class="col-12 ">
                                <h3 class="font-weight-bold pg-heading">
                                    {{ pageTitle }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div v-bind:style="{ display: loading ? 'block' : 'none' }" class="col-12 skeleton-outer p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="skeleton w-100 border-radius mb-20" style="height: 50px;"></div>
                            </div>
                        </div>
                    </div>
                    <div v-show="!loading" class="col-12 grid-margin">
                        <div class="row">
                            <div class="group-sec-outer col-12 col-md-6">
                            </div>
                            <div class="flt-right-sec col-12 col-md-6">
                                <div class="flt-right-datepicker">
                                    <date-range-picker id="calendar_filter" :start-date="start_date"
                                                       :end-date="end_date"
                                                       v-on:dateRangeChanged="onDateRangeChanged"></date-range-picker>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main content section -->
                <div class="main-inner-content row">

                    <div class="col-12 skeleton-outer p-0">
                        <div class="row stretch-card">
                            <div class="col-4 col-sm-6 col-md-4 col-lg-4">
                                <div class=" border-radius skeleton w-100"></div>
                            </div>
                            <div class="col-4 col-sm-6 col-md-4 col-lg-4">
                                <div class=" border-radius skeleton w-100"></div>
                            </div>
                            <div class="col-4 col-sm-6 col-md-4 col-lg-4">
                                <div class=" border-radius skeleton w-100"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 ">
                                <ul class="skeleton-listing">
                                    <li class="border-radius skeleton" style="height:435px!important;"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 sub-sections">

                        <div class="row grid-margin">
                            <div class="col-12 row">

                                <!-- Left section -->
                                <div class="col-4 card-status d-flex">
                                    <div class="card-detail col-6 d-flex flex-column justify-content-around">
                                        <div class="d-flex flex-row justify-content-start align-items-start">
                                            <p>Total Orders</p>
                                        </div>
                                        <span class="amount">{{ this.stats.totalOrders }}</span>
                                    </div>
                                </div>

                                <div class=" col-4 card-status d-flex card-prim-blue ">
                                    <div class="card-detail col-6 d-flex flex-column justify-content-around">
                                        <div class="d-flex flex-row justify-content-start align-items-start">
                                            <p>Total Customers</p>
                                        </div>
                                        <span class="amount">{{this.stats.totalCustomers }}</span>
                                    </div>
                                </div>

                                <div class="col-4 card-status d-flex">
                                    <div class="card-detail col-6 d-flex flex-column justify-content-around">
                                        <div class="d-flex flex-row justify-content-start align-items-start">
                                            <p>Total Revenue</p>
                                        </div>
                                        <span class="amount">$ {{this.stats.totalRevenue | formatNumber }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" row grid-margin">
                            <div class="col-12 row ">
                                <div id="stats_chart">Chart</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
</script>
<script >

//Custom Date Range Component
Vue.component('date-range-picker', {
    props: ['id', 'startDate', 'endDate'],
    template: '<input type="text" class="form-control" :id="id" :name="id" style="border-radius: 50px" />',
    mounted: function () {
        var self = this;
        var input = $('input[name="' + this.id + '"]');
        input.daterangepicker({
            "startDate": this.startDate,
            "endDate": this.endDate,
            "minDate": moment("2015-01-01"),
            "maxDate": moment().subtract(1, 'days'),
        });
        input.on('apply.daterangepicker', function (ev, picker) {
            self.$emit('daterangechanged', picker);
        });
    }
});

// Filter to formate numbers
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0");
});

var app = new Vue({
    el: '#main_wrapper',
    data: {
        loading: false,
        pageTitle: 'Dashboard',
        start_date: moment().subtract(1, 'months').startOf('month'),
        end_date: moment().subtract(1, 'months').endOf('month'),
        filter: {
            start_date: moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
            end_date: moment().subtract(1, 'months').endOf('month').format("YYYY-MM-DD")
        },
        API_URL: "<?php echo $API_URL; ?>",
        stats: {totalOrders: 0, totalCustomers: 0, totalRevenue: 0, customerStats: [], orderStats: []},
    },
    mounted() {
        this.getStats();
    },
    methods: {

        onDateRangeChanged: function (picker) {
            let _this = this;
            this.filter.start_date = moment(picker.startDate).format("YYYY-MM-DD");
            this.filter.end_date = moment(picker.endDate).format("YYYY-MM-DD");
            _this.$nextTick(function () {
                _this.getStats();
            });
        },

        // Display Customer & Orders Stats using highchart
        showStatsGraph() {

            let OrderStats = this.stats.orderStats;
            let customerStats = this.stats.customerStats;
            let orderData = [];
            if (typeof OrderStats !== typeof  undefined) {
                    orderData = Object.keys(OrderStats).map(function (key){return {x:new Date(OrderStats[key].purchase_date).getTime(),y:parseFloat(OrderStats[key].totalOrders)}});
            }
            let customerData = [];
            if (typeof customerStats !== typeof  undefined) {
                customerData = Object.keys(customerStats).map(function(key){return {x:new Date(customerStats[key].created_at).getTime(), y:parseFloat(customerStats[key].totalCustomers)}});
            }

            var seriesData = [{
                'name': 'Orders',
                'data': orderData,
            }, {
                'name': 'Customers',
                'data': customerData,
            }];

           Highcharts.chart('stats_chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Customer & Order Stats'
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        rotation: -45,
                        align: 'right'
                    },
                    dateTimeLabelFormats: {
                        day: '%b  %e',
                    }
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: false,
                        }
                    }
                },
                series: seriesData,
               lang: {
                   noData: "No stats found!"
               },
                credits: {
                    enabled: false
                }
            });

        },

        enumerateDaysBetweenDates(startDate, endDate) {

            var dates = [];
            var currDate = moment(startDate).startOf('day');
            var lastDate = moment(endDate).startOf('day');
            dates.push(currDate.clone().toDate());
            while(currDate.add(1, 'days').diff(lastDate) <= 0) {
                dates.push(currDate.clone().toDate());
            }
            return dates;
        },

        // Reset Stats object
        resetStats() {

            this.packages = []
            this.stats.customerStats = [];
            this.stats.orderStats = [];
            this.stats.totalCustomers = 0;
            this.stats.totalOrders = 0;
            this.stats.totalRevenue = 0;
            this.loading = false;
            return true;
        },
        // Get Stats
        getStats() {
            let _this = this;
            _this.loading = true
            axios.defaults.headers.common['http-x-requested-with'] = 'XMLHttpRequest';
            axios({
                method: 'get',
                url: _this.API_URL + 'stats',
                params: {..._this.filter},
            }).then(function (response) {

                if (response.status === 200 && response.data.status === true) {
                    _this.stats.totalCustomers = response.data.data.totalCustomers;
                    _this.stats.totalOrders = response.data.data.totalOrders;
                    _this.stats.totalRevenue = response.data.data.totalRevenue;
                    _this.stats.orderStats = response.data.data.orderStats;
                    _this.stats.customerStats = response.data.data.customerStats;
                    _this.$nextTick(function () {
                        _this.showStatsGraph();
                    });

                } else {
                    _this.resetStats();
                }
                _this.loading = false;
            }).catch(function (error) {
                _this.resetStats();
                _this.loading = false;
            });
        },
    }
});
</script>