@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card-deck">
            <div class="card box-shadow">
                <div class="card-header">
                    <h3 class="float-left">OS</h3>
                </div>

                <div class="card-body">
                    <canvas id="os" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header">
                    <h3 class="float-left">Daily Active Devices</h3>
                </div>

                <div class="card-body">
                    <canvas id="daily_active_devices" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header">
                    <h3 class="float-left">Weekly Active Devices</h3>
                </div>

                <div class="card-body">
                    <canvas id="weekly_active_devices" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header">
                    <h3 class="float-left">Monthly Active Devices</h3>
                </div>

                <div class="card-body">
                    <canvas id="monthly_active_devices" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header">
                    <h3 class="float-left">Zahlen</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="basic_numbers">
                            <thead class="thead-dark">
                            <th>Auswertung</th>
                            <th>#</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-deck mt-lg-3">
            <div class="card box-shadow">
                <div class="card-header">
                    <h3 class="float-left">App-Version</h3>
                </div>

                <div class="card-body">
                    <canvas id="app_version" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header">
                    <h3 class="float-left">Trackings</h3>
                </div>

                <div class="card-body">
                    <canvas id="trackings" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $.each(['os', 'trackings', 'app_version', 'weekly_active_devices', 'daily_active_devices', 'monthly_active_devices'], function (_index, reporting) {
            $.getJSON('/api/statics/' + reporting, function (data) {
                let _data = [];
                let _labels = [];
                let _colors = [];
                $.each(data, function (index, val) {
                    _data.push(val.value);
                    _labels.push(val.label + ' (' + val.value + ')');
                    if (val.color == undefined) {
                        _colors.push(getRandomColor());
                    } else {
                        _colors.push(val.color);
                    }
                });
                // And for a doughnut chart
                var myDoughnutChart = new Chart(reporting, {
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
        });
        $.getJSON('/api/statics/table', function (data) {
            $.each(data, function (index, val) {
                let row = $('<tr></tr>');
                $('<td></td>').text(val.label).appendTo(row);
                $('<td></td>').text(val.value).appendTo(row);
                row.appendTo('#basic_numbers tbody')
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