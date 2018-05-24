@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">Create Feature Flag</h3>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('feature_flags.store.store') }}">
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
                                <input type="url" class="form-control" id="description" name="description"
                                       value="{{old('description')}}">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
