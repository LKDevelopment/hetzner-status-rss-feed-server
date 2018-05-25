@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Devices</h3>
                    </div>
                    
                    <div class="card-body">
                        <div id="devices"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let _data = [];
        let _labels = [];
        $.getJSON('/api/device/metrics2', function (data) {
            $.each(data, function (index, val) {
                _data.push(val.value);
                _labels.push(val.os);
            });
            // And for a doughnut chart
            var myDoughnutChart = new Chart('devices', {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: _data
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: _labels
                }
            });
        });
    
    </script>
@endpush