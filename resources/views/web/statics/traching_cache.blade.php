@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Traceing Cache</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                            <th>ID</th>
                            <th>IP</th>
                            </thead>
                            <tbody>
                            @foreach($caches as $id => $cache)
                                <tr>
                                    <td>{{ $id}}</td>
                                    <td>{{ $cache }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
