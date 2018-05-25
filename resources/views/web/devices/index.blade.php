@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">Devices</h3>
                    </div>

                    <div class="card-body">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <form class="form-inline" method="GET">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">Device ID/Description</span>
                                    </div>
                                    <input type="text" name="value" class="form-control" required
                                           value="{{ request()->get('value') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="text-muted">Durch Eingabe des Types werden alle Geräte des Types angegegben: z.B.
                            developer oder user oder internal</p>
                        @if($devices !== null)
                            <table class="table table-bordered table-condensed table-striped">
                                <thead>
                                <th>ID</th>
                                <th>Description</th>
                                <th>OS</th>
                                <th>App Version</th>
                                <th>Aktionen</th>
                                </thead>
                                <tbody>
                                @foreach($devices as $device)
                                    <tr>
                                        <td>{{ $device->id }}</td>
                                        <td>{{ $device->description }}</td>
                                        <td>{{$device->os}} {{ $device->version }}</td>
                                        <td>{{ $device->app_version }}</td>
                                        <td>
                                            <a href="{{ route('devices.show',$device) }}"
                                               class="btn btn-outline-success btn-sm" data-toggle="tooltip"
                                               data-placement="bottom" title="Details"><i
                                                        class="fas fa-fw fa-info-circle"></i></a>
                                            <a href="{{ route('devices.edit',$device) }}"
                                               class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                               data-placement="bottom" title="Editieren"><i
                                                        class="fas fa-fw fa-pencil"></i></a>
                                            <a href="{{ route('devices.feature_flags',$device) }}"
                                               class="btn btn-outline-warning btn-sm" data-toggle="tooltip"
                                               data-placement="bottom" title="Feature Flags"><i
                                                        class="fas fa-flag fa-fw"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$devices->appends(['value' => request()->get('value') ])->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
