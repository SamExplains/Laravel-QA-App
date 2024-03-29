<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions() {
      return $this->hasMany(Question::class);
    }

  public function getUrlAttribute() {
//    return route('questions.show', $this->id);
      return '#';
  }

  public function answers(){
    return $this->hasMany(Answer::class);
  }

  public function getAvatarAttribute(){
    $email = $this->email;
    $size = 32;
    return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
  }

  public function favorites(){
      return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); /* 'user_id', 'question_id' */
  }

  public function voteQuestions(){
      return $this->morphedByMany(Question::class, 'votable');
  }

  public function voteAnswers(){
      return $this->morphedByMany(Answer::class, 'votable_type');
  }

  public function voteQuestion(Question $question, $vote){
    $voteQuestions = $this->voteQuestions();
    if ($voteQuestions->where('votable_id', $question->id)->exists()) {
      $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
    } else {
      $voteQuestions->attach($question, ['vote' => $vote]);
    }

    $question->load('votes'); /* refresh votes relationship */
    $downvotes = (int) $question->downVotes()->sum('vote'); /* sum instead of count since count will count and return positive where sum will add everything */
    $upvotes = (int) $question->upVotes()->sum('vote'); /* sum instead of count since count will count and return positive where sum will add everything */
    $question->votes_count = $upvotes + $downvotes;
    $question->save();

  }

  public function voteAnswer(Answer $answer, $vote) {
    $voteAnswers = $this->voteQuestions();
    if ($voteAnswers->where('votable_id', $answer->id)->exists()) {
      $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
    } else {
      $voteAnswers->attach($answer, ['vote' => $vote]);
    }

    $answer->load('votes'); /* refresh votes relationship */
    $downvotes = (int) $answer->downVotes()->sum('vote'); /* sum instead of count since count will count and return positive where sum will add everything */
    $upvotes = (int) $answer->upVotes()->sum('vote'); /* sum instead of count since count will count and return positive where sum will add everything */
    $answer->votes_count = $upvotes + $downvotes;
    $answer->save();

  }


}
