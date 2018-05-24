@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
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
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Device ID/Description">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="value" class="form-control" required
                                           value="{{ request()->get('value') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                                            <a href="{{ route('devices.edit',$device) }}" class="btn btn-info">Edit</a>
                                            <a href="#" class="btn btn-success">Feature Flags</a>
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
