@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-title">
                    <div class="d-flex align-items-center">
                      <h1>{{ $question->title }}</h1>
                      <div class="ml-auto">
                        <a href="{{ route('questions.index') }}" class="btn btn-primary">Back</a>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="media">

                    <div class="d-flex flex-column vote-controls">
                      <a title="This question is useful"
                         class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                         onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit()"
                      >
                        <i class="fa fa-caret-up"></i>
                      </a>

                      <form id="up-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="POST" style="display: none">
                        @csrf
                        <input type="hidden" name="vote" value="1">
                      </form>

                      <span class="votes-count">{{ $question->votes_count }}</span>
                      <a title="This question was terrible"
                         class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                         onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit()"
                      >
                        <i class="fa fa-caret-down"></i>
                      </a>

                      <form id="down-vote-question-{{ $question->id }}" action="/questions/{{ $question->id }}/vote" method="POST" style="display: none">
                        @csrf
                        <input type="hidden" name="vote" value="-1">
                      </form>

                      <a title="Click to mark as favorite question (Click again to undo)"
                         class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }} "
                         onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit()"
                        >
                        <i class="fa fa-star"></i>
                        <span class="favorites-count">{{ $question->favorites_count }}</span>
                      </a>

                      <form id="favorite-question-{{ $question->id }}" action="/questions/{{ $question->id }}/favorites" method="POST" style="display: none">
                        @csrf
                        @if ($question->is_favorited)
                          @method('DELETE')
                        @endif
                      </form>

                    </div>

                    <div class="media-body">
                      {!! $question->body_html !!}
                      <div class="float-right">
                        <span class="text-muted">Created By {{ $question->created_date }}</span>
                        <div class="media">
                          <a href="{{ $question->user->url }}" class="pr-2">
                            <img src="{{ $question->user->avatar }}" alt="">
                          </a>

                          <div class="media-body">
                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                          </div>

                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
</div>

      @include('answers._index', ['answers' => $question->answers, 'answers_count' => $question->answers_count ])
      @include('answers._create')
  </div>
@endsection
