@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-primary">+</a>
                        </div>
                    </div>
                    </div>

                    <div class="card-body">
                        @include('layouts._messages')
                        @foreach($questions as $question)

                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{ $question->votes_count  }}</strong> {{ str_plural('vote', $question->votes_count) }}
                                    </div>
                                    <div class="status {{ $question->status }}">
                                        <strong>{{ $question->answers_count  }}</strong> {{ str_plural('answers_count', $question->answers_count) }}
                                    </div>
                                    <div class="view">
                                        {{ $question->views  }}  {{ str_plural('view', $question->views) }}
                                    </div>
                                </div>

                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0">
                                            <a href="{{ $question->url }}">{{$question->title}}</a>
                                        </h3>
                                      <div class="ml-auto">
                                          @can ('update', $question)
                                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-success">Edit</a>
                                          @endcan
                                      </div>
                                        @can ('delete', $question)
                                          <form action="{{route('questions.destroy', $question->id)}}" method="post">
                                              @method('DELETE')
                                              @csrf {{--  Blade directive token--}}
                                              <button type="submit" class="btn btn-danger btn-sm ml-1" onclick="return confirm('Are you sure?')">X</button>
                                          </form>
                                        @endcan

                                    </div>
                                    <p class="lead">
                                        Asked by <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{$question->created_date}}</small>
                                    </p>
                                    {{ str_limit($question->body, 250) }}
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <div class="justify-content-center">
                            {{ $questions->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
