<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">

        <div class="card-title">
          <h2>{{ $answers_count . " " . str_plural('Answer', $answers_count) }}</h2>
        </div>

        <hr>

        @include('layouts._messages')

        @foreach($answers as $answer)

          <div class="media">

            <div class="d-flex flex-column vote-controls">
              <a title="This answer is useful" class="vote-up">
                <i class="fa fa-caret-up"></i>
              </a>
              <span class="votes-count">1230</span>
              <a title="This answer was terrible" class="vote-down off">
                <i class="fa fa-caret-down"></i>
              </a>

              @can('accept', $answer)
                <a title="Mark this answer as best answer" class="{{ $answer->status }} mt-2" onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit()">
                  <i class="fa fa-check"></i>
                  <span class="favorites-count"></span>
                </a>

                <form id="accept-answer-{{ $answer->id }}" action="{{ route('answers.accept', $answer->id) }}" method="POST" style="display: none">
                  @csrf
                </form>

                @else
                @if ($answer->is_best)
                  <a title="Current answer is best answer" class="{{ $answer->status }} mt-2">
                    <i class="fa fa-check"></i>
                    <span class="favorites-count"></span>
                  </a>
                @endif
              @endcan

            </div>

            <div class="media-body">
              {!! $answer->body_html !!}

              <div class="row">
                <div class="col-4">
                  <div class="ml-auto">
                    @can ('update', $answer)
                      <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    @endcan

                    @can ('delete', $answer)
                      <form class="form-delete" action="{{route('questions.answers.destroy', [$question->id, $answer->id] )}}" method="post">
                        @method('DELETE')
                        @csrf {{--  Blade directive token--}}
                        <button type="submit" class="btn btn-outline-danger btn-sm ml-1" onclick="return confirm('Are you sure?')">Delete</button>
                      </form>
                    @endcan

                  </div>
                </div>

                <div class="col-4"></div>

                <div class="col-4">
                  <span class="text-muted">Answered {{ $answer->created_date }}</span>
                  <div class="media">
                    <a href="{{ $answer->user->url }}" class="pr-2">
                      <img src="{{ $answer->user->avatar }}" alt="">
                    </a>

                    <div class="media-body">
                      <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                    </div>

                  </div>
                </div>

              </div>

            </div>
          </div>

          <hr>

        @endforeach

      </div>
    </div>
  </div>
</div>