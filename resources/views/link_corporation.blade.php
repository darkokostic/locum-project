@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="resources-top">
            <div class="col-xs-12">
                <h1>
                    Corporation
                </h1>
            </div>
            <div class="latest-vacancies-description col-xs-12">
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </p>
            </div>
            <div class="col-xs-12">
                <div class="line">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default corporation-create">
                    <div class="panel-heading corporation-heading header-meni-create-corp">
                        <p class="text-header-corporation col-xs-7"><i class="fa fa-building-o create-corp-icon" aria-hidden="true"></i>Create Corporation</p>
                        <a class="btn btn-default pull-right btn-create-corporation create-corporation-heading-btn" href="{{ route('create_corporation') }}">Create Corporation</a>
                    </div>

                    <form action="{{ url('corporation/link') }}" method="post" >
                        <div class="panel-body">
                            <div class="form-group col-md-5 col-xs-12">
                                <label for="example-text-input" class="col-2 col-form-label">Corporation </label>
                                <div class="col-10">
                                    <select name="corporation" class="form-control input-create-corp">
                                        @foreach($corporations as $corporation)
                                            <option value="{{$corporation->id}}">{{$corporation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-5 col-xs-12">
                                <label for="example-search-input" class="col-2 col-form-label">Practice</label>
                                <div class="col-10">
                                    <select name="practice" class="form-control input-create-corp">
                                        @foreach($practices as $practice)
                                            <option value="{{ $practice->id}}">{{ $practice->practice_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row col-md-2 col-xs-12">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-default btn-create-corporation link-create-corp">Link</button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection