<?php namespace App;

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class History extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['history_id_history', 'user_id_user', 'history_play_time'];

    /**
     * A user own an history
     */
    public function user(){
        return $this->belongsTo('App/User.php');
    }

    /**
     * An history can have many musics
     */
    public function music(){
        return $this->hasMany('App/Music.php');
    }

}
?>
