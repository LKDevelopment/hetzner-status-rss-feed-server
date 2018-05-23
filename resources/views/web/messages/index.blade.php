@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Messages</h3>
                        <a href="{{ route('messages.create') }}" class="btn btn-success float-right">Add</a>
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
                            <th>Title</th>
                            <th>Kategorie</th>
                            <th>Erstellt</th>
                            <th>Push versendet?</th>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <td>{{ $message->external_id }}</td>
                                    <td>{{ $message->title_de }}</td>
                                    <td>{{$message->category}}</td>
                                    <td>{{ $message->created_at }}</td>
                                    <td>{{$message->send_at ? 'Ja':'Nein'}}</td>
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
