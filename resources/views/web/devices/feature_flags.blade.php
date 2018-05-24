@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Device
                            <small>{{ $device->id }}</small>
                            Feature Flags
                        </h3>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('devices.feature_flags',$device) }}">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}
                            <table class="table">
                                <thead>
                                <th>Flag</th>
                                <th>Checkbox</th>
                                </thead>
                                <tbody>
                                @foreach(\App\Model\Device\FeatureFlag::all() as $feature_flag)
                                    <tr>
                                        <td>
                                            <label class="form-check-label" for="exampleCheck1">{{ $feature_flag->description }}</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-check-input" name="featureFlag[]" value="{{ $feature_flag->id }}" {{ $device->hasFeatureFlag($feature_flag) ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary"><i class="fal fa-save"></i> Speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
