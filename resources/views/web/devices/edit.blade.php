@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Edit Device {{ $device->id }}</h3>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('messages.update',$device) }}">
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
                                        User
                                    </option>
                                    <option value="internal" {{ old('type', $device->type) == 'internal' ? 'selected' :'' }}>
                                        Beta
                                        Tester
                                    </option>
                                    <option value="developer" {{ old('type', $device->type) == 'developer' ? 'selected' :'' }}>
                                        Developer
                                    </option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
