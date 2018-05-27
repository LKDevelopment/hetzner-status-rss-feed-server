@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">Devices</h3>
                    </div>
                    
                    <div class="card-body">
                        <canvas id="devices" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">Daily Active Devices</h3>
                    </div>
                    
                    <div class="card-body">
                        <canvas id="daily_active_devices" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">Weekly Active Devices</h3>
                    </div>
                    
                    <div class="card-body">
                        <canvas id="weekly_active_devices" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">Monthly Active Devices</h3>
                    </div>

                    <div class="card-body">
                        <canvas id="monthly_active_devices" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">App-Version</h3>
                    </div>
                    
                    <div class="card-body">
                        <canvas id="app_version" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

        let device_colors = ['#89BF64', '#F7D247', '#327BF6'];
        $.getJSON('/api/statics/os', function (data) {
            let _data = [];
            let _labels = [];
            $.each(data, function (index, val) {
                _data.push(val.value);
                _labels.push(val.os);
            });
            // And for a doughnut chart
            var myDoughnutChart = new Chart('devices', {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: _data,
                        backgroundColor: device_colors,
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: _labels
                }
            });
        });
        $.getJSON('/api/statics/app_version', function (data) {
            let _data = [];
            let _labels = [];
            let _colors = [];
            $.each(data, function (index, val) {
                _data.push(val.value);
                _labels.push(val.app_version);
                _colors.push(getRandomColor());
            });
            // And for a doughnut chart
            var myDoughnutChart = new Chart('app_version', {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: _data,
                        backgroundColor: _colors,
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: _labels
                }
            });
        });
        $.getJSON('/api/statics/weekly_active_devices', function (data) {
            let _data = [];
            let _labels = [];
            let _colors = [];
            $.each(data, function (index, val) {
                _data.push(val.value);
                _labels.push(val.label);
                _colors.push(val.color);
            });
            // And for a doughnut chart
            var myDoughnutChart = new Chart('weekly_active_devices', {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: _data,
                        backgroundColor: _colors,
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: _labels
                }
            });
        });
        $.getJSON('/api/statics/daily_active_devices', function (data) {
            let _data = [];
            let _labels = [];
            let _colors = [];
            $.each(data, function (index, val) {
                _data.push(val.value);
                _labels.push(val.label);
                _colors.push(val.color);
            });
            // And for a doughnut chart
            var myDoughnutChart = new Chart('daily_active_devices', {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: _data,
                        backgroundColor: _colors,
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: _labels
                }
            });
        });
        $.getJSON('/api/statics/monthly_active_devices', function (data) {
            let _data = [];
            let _labels = [];
            let _colors = [];
            $.each(data, function (index, val) {
                _data.push(val.value);
                _labels.push(val.label);
                _colors.push(val.color);
            });
            // And for a doughnut chart
            var myDoughnutChart = new Chart('monthly_active_devices', {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: _data,
                        backgroundColor: _colors,
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: _labels
                }
            });
        });
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    
    </script>
@endpush