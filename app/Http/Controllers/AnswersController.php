<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

  /**
   * Store a newly created resource in storage.
   *
   * @param Question $question
   * @param  \Illuminate\Http\Request $request
   * @return void
   */
    public function store(Question $question, Request $request)
    {
        //
      $question->answers()->create($request->validate([
        'body' => 'required'
        ]) + ['user_id' => \Auth::id()
        ]);

      return back()->with('success', "Your answer was submitted");
    }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Question $question
   * @param  \App\Answer $answer
   * @return void
   */
    public function edit(Question $question, Answer $answer)
    {
        //
      $this->authorize('update', $answer);

      return view('answers._edit', compact('question', 'answer'));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param Question $question
   * @param  \App\Answer $answer
   * @return void
   */
    public function update(Request $request, Question $question, Answer $answer)
    {
        //
      $this->authorize('update', $answer);

      $answer->update($request->validate([
        'body' => 'required',
      ]));

      return redirect()->route('questions.show', $question->slug)->with('success', 'Answer was upadted');


    }

  /**
   * Remove the specified resource from storage.
   *
   * @param Question $question
   * @param  \App\Answer $answer
   * @return void
   */
    public function destroy(Question $question, Answer $answer)
    {
        //
      $this->authorize('delete', $answer);

      $answer->delete();

      return back()->with('success', "Answer was deleted");

    }
}
