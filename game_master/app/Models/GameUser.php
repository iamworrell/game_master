<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GameUser extends Model
{
  //This ensures every new GameUser gets a UUID automatically.
  protected static function boot()
  {
      parent::boot();

      static::creating(function ($model) {
          $model->uuid = Str::uuid()->toString();
      });
  }

  //manually set the table the model connect to
  protected $table = 'game_users';

  //manually set the primary key of the model
  protected $primaryKey = 'id';

  //turn off autoincrementing for the primary key
  // public $incrementing = false;
  // protected $keyType = 'string';

  //allows for mass assignment of data in each column at the same time
  protected $fillable = [
    'username',
    'password',
    'email',
    'master_icon_path',
    'first_name',
    'last_name',
    'country',
    'city',
    'birthdate_date_format',
    'birthdate_string_format',
    'gender',
    'user_bio',
    'points',
    'game_history',
    'game_history_id',
  ];


  //Allows the model to access data in the table with the foreign key
  public function history()
  {
    return $this->belongsTo(GameHistory::class, 'game_history_id');
  }
}
