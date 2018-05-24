@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Create Messages</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('messages.store') }}">
                            {{csrf_field()}}
                            <h3>Deutsch</h3>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title:</label>
                                <input type="text" class="form-control" id="title_de" name="title_de"
                                       value="{{old('title_de')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Betroffen:</label>
                                <input type="text" class="form-control" id="affected_de" name="affected_de"
                                       value="{{old('affected_de')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Permalink:</label>
                                <input type="url" class="form-control" id="permalink_de" name="permalink_de"
                                       value="{{old('permalink_de')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Beschreibung:</label>
                                <textarea name="description_de"
                                          class="form-control">{{old('description_de')}}</textarea>
                            </div>
                            <h3>English</h3>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title:</label>
                                <input type="text" class="form-control" id="title_en" name="title_en"
                                       value="{{old('title_en')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Betroffen:</label>
                                <input type="text" class="form-control" id="affected_en" name="affected_en"
                                       value="{{old('affected_en')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Permalink:</label>
                                <input type="url" class="form-control" id="permalink_en" name="permalink_en"
                                       value="{{old('permalink_en')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Beschreibung:</label>
                                <textarea name="description_en" class="form-control">{{old('end')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Category:</label>
                                <select name="category" class="form-control">
                                    <option value="App" {{ old('category') == 'App' ? 'selected' :'' }}>App</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Start:</label>
                                <input type="text" class="form-control" id="start" name="start"
                                       placeholder="YYYY-MM-DD HH:ii:ss" value="{{old('start')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">End:</label>
                                <input type="text" class="form-control" id="end" name="end"
                                       placeholder="YYYY-MM-DD HH:ii:ss" value="{{old('end')}}">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1"required>
                                <label class="form-check-label" for="exampleCheck1" >Achtung! Die Nachrichten
                                    werden direkt versendet!</label>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fal fa-save fa-fw"></i> Speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
