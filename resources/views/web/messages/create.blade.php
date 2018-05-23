@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Create Messages</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            {{csrf_field()}}
                            <h3>Deutsch</h3>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title:</label>
                                <input type="text" class="form-control" id="title_de" name="title_de">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Betroffen:</label>
                                <input type="text" class="form-control" id="affected_de" name="affected_de">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Permalink:</label>
                                <input type="url" class="form-control" id="permalink_de" name="permalink_de">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Beschreibung:</label>
                                <textarea name="description_de" class="form-control"></textarea>
                            </div>
                            <h3>English</h3>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title:</label>
                                <input type="text" class="form-control" id="title_en" name="title_en">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Betroffen:</label>
                                <input type="text" class="form-control" id="affected_en" name="affected_en">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Permalink:</label>
                                <input type="url" class="form-control" id="permalink_en" name="permalink_en">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Beschreibung:</label>
                                <textarea name="description_en" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Category:</label>
                                <select name="category" class="form-control">
                                    <option value="App">App</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Start:</label>
                                <input type="text" class="form-control" id="start" name="start"
                                       placeholder="YYYY-MM-DD HH:ii:ss">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">End:</label>
                                <input type="text" class="form-control" id="start" name="start"
                                       placeholder="YYYY-MM-DD HH:ii:ss">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        $_payload = [
                        'title_'.$languageCode => $item->title,
                        'description_'.$languageCode => null,
                        'affected_'.$languageCode => null,
                        'permalink_'.$languageCode => $item->permalink,
                        'category' => null,
                        'start' => null,
                        'end' => null,
                        'external_id' => $external_id,
                        'parent_id' => $parent_id,
                        ];
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
