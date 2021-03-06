@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card box-shadow">
                    <div class="card-header">
                        <h3 class="float-left">Create Feature Flag</h3>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('feature_flags.store') }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Key:</label>
                                <input type="text" class="form-control" id="key" name="key"
                                       value="{{old('key')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Min Build:</label>
                                <input type="text" class="form-control" id="min_build" name="min_build"
                                       value="{{old('affected_de')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Description:</label>
                                <input type="text" class="form-control" id="description" name="description"
                                       value="{{old('description')}}">
                            </div>
                            
                            <button type="submit" class="btn btn-primary"><i class="fal fa-save fa-fw"></i> Speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
