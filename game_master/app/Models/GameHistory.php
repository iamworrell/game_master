<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
  //manually set the table the model connect to
  protected $table = 'game_history';

  protected $fillable = ['username', 'history', 'wins', 'loses'];

  //Allows the model to access data in the table with the foreign key
  public function user()
  {
    return $this->hasOne(GameUser::class, 'game_history_id');
  }
}