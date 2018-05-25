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
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <i class="fab fa-fw {{ $device->os == 'iOS' ? 'fa-apple':'fa-android' }} fa-4x avatar"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table>
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
                </div>
            </div>
        </div>
    </div>
@endsection
