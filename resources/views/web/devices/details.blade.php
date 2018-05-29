@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h2 class="float-left">Device
                            <small>{{ strlen($device->description) > 0 ? $device->description:$device->id }}</small>
                        </h2>
                        <div class="btn-group float-right" role="group" aria-label="Basic example">
                            <a href="{{ route('devices.edit',$device) }}"
                               class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                               data-placement="bottom" title="Editieren"><i
                                        class="fas fa-fw fa-pencil"></i></a>
                            <a href="{{ route('devices.feature_flags',$device) }}"
                               class="btn btn-outline-warning btn-sm" data-toggle="tooltip"
                               data-placement="bottom" title="Feature Flags"><i
                                        class="fas fa-flag fa-fw"></i></a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td><strong>OS:</strong></td>
                                            <td>{{$device->os}}
                                                <i class="fab fa-fw {{ $device->os == 'iOS' ? 'fa-apple':'fa-android' }} fa-2x"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Version</strong></td>
                                            <td>{{$device->version}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="float-right">
                                    <div class="table-responsive table">
                                        <table>
                                            <tr>
                                                <td><strong>ID:</strong></td>
                                                <td>{{$device->id}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Beschreibung:</strong></td>
                                                <td>{{$device->description}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Typ:</strong></td>
                                                <td>{{ $device->type }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>App Version:</strong></td>
                                                <td>{{$device->app_version}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Letzte Änderung:</strong></td>
                                                <td>{{$device->updated_at}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <th>ID</th>
                                        <th>Datum</th>
                                        <th>Projekte (Cloud)</th>
                                        <th>Zugänge (Robot)</th>
                                        </thead>
                                        <tbody>
                                        @foreach($device->trackings()->orderByDesc('id')->limit(5)->get() as $tracking)
                                            <tr>
                                                <td>{{ $tracking->id }}</td>
                                                <td>{{$tracking->created_at->format('d.m.Y H:i:s')}}</td>
                                                <td>{{ $tracking->projects }}</td>
                                                <td>{{$tracking->access}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-deck mt-l2">
                            <div class="card box-shadow">
                                <div class="card-header text-center">
                                    <strong>Feature Usage All Time</strong>
                                </div>
            
                                <div class="card-body">
                                    <canvas id="features_all" width="400" height="400"></canvas>
                                </div>
                            </div>
                            <div class="card box-shadow">
                                <div class="card-header text-center">
                                    <strong>Feature Usage Current Month</strong>
                                </div>
            
                                <div class="card-body">
                                    <canvas id="features_current_month" width="400" height="400"></canvas>
                                </div>
                            </div>
                            <div class="card box-shadow">
                                <div class="card-header text-center">
                                    <strong>Feature Usage Last Month</strong>
                                </div>
            
                                <div class="card-body">
                                    <canvas id="features_last_month" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $.each(['features_all', 'features_current_month', 'features_last_month'], function (_index, reporting) {
            $.getJSON('/api/statics/{{$device->id}}/' + reporting, function (data) {
                let _data = [];
                let _labels = [];
                let _colors = [];
                $.each(data, function (index, val) {
                    _data.push(val.value);
                    _labels.push(val.label + ' (' + val.value + ')');
                    if (val.color == undefined) {
                        _colors.push(ColorHash.hex(val.label));
                    } else {
                        _colors.push(val.color);
                    }
                });
                // And for a doughnut chart
                new Chart(reporting, {
                    type: 'doughnut',
                    legend: {
                        display: true,
                    },
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