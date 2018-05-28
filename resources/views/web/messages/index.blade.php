@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card box-shadow">
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
                            <form class="form-inline" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">Suche</span>
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
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Kategorie</th>
                            <th>Erstellt</th>
                            <th>Push versendet?</th>
                            <th>Aktionen</th>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <td>{{ $message->id }} (Ext: {{$message->external_id}})</td>
                                    <td>{{ $message->title_de }}</td>
                                    <td>{{$message->category}}</td>
                                    <td>{{ $message->created_at }}</td>
                                    <td>{{$message->send_at ? 'Ja':'Nein'}}</td>
                                    <td>@if($message->category == 'App')
                                            <a href="{{ route('messages.delete',$message) }}" class="text-danger"><i class="fal fa-trash fa-fw"></i>
                                                Delete</a>
                                        @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                        {{$messages->appends(['value' => request()->get('value') ])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
