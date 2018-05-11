@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Messages</div>

                    <div class="card-body">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                            <th>ID</th>
                            <th>Titel</th>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <td>{{ $message->external_id }}</td>
                                    <td>{{ $message->title_de }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{$messages->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
