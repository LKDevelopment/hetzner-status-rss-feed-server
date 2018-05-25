@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card  box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">Device
                            <small>{{ strlen($device->description) > 0 ? $device->description:$device->id }}</small>
                            editieren
                        </h3>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('devices.update',$device) }}">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="exampleInputEmail1">ID:</label>
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $device->id }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="exampleInputEmail1">OS:</label>
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $device->os }} {{ $device->version }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="exampleInputEmail1">App Version:</label>
                                    <input type="text" readonly class="form-control-plaintext" value="{{ $device->app_version }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Beschreibung:</label>
                                <input type="text" class="form-control" id="title_de" name="description"
                                       value="{{old('description', $device->description)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Typ:</label>
                                <select name="type" class="form-control">
                                    <option value="user" {{ old('type', $device->type) == 'user' ? 'selected' :'' }}>
                                        Benutzer
                                    </option>
                                    <option value="internal" {{ old('type', $device->type) == 'internal' ? 'selected' :'' }}>
                                        Beta
                                        Tester
                                    </option>
                                    <option value="developer" {{ old('type', $device->type) == 'developer' ? 'selected' :'' }}>
                                        Entwickler
                                    </option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary"><i class="fal fa-save"></i> Speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
