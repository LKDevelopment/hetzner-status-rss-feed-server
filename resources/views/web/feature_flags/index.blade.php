@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Feature Flags</h3>
                        <a href="{{ route('feature_flags.create') }}" class="btn btn-success float-right">Add</a>
                    </div>
                    
                    <div class="card-body">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Key</th>
                            <th>min_build</th>
                            <th>Aktionen</th>
                            </thead>
                            <tbody>
                            @foreach($featureFlags as $featureFlag)
                                <tr>
                                    <td>{{ $featureFlag->id }}</td>
                                    <td>{{ $featureFlag->description }}</td>
                                    <td>{{$featureFlag->key}}</td>
                                    <td>{{ $featureFlag->min_build }}</td>
                                    
                                    <td>
                                        <a href="{{ route('feature_flags.delete',$featureFlag) }}" class="text-danger"><i class="fal fa-trash fa-fw"></i> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                        {{$featureFlags->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
