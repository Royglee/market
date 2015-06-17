<?php namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @property  user_id
 * @property int id
 */
class Account extends Model
{

    protected $fillable = [
        'countq','count','first_owner','has_email','duration','delivery','title','server','league',
        'division','champions','skins','price','body'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeWithUser($query, $array_columns = ["*"])
    {
        if ( $array_columns != ["*"] && !in_array('id', $array_columns)) {
            array_unshift($array_columns, 'id');
        }
        return $query->with(['user' => function ($query) use ($array_columns) {
            $query->select($array_columns);
        }]);
    }

    public function setDivisionAttribute($value)
    {
        $league = $this->attributes['league'];

        if ($league !== 'Unranked' && $league !== 'Master' && $league !== 'Challenger') {
            $this->attributes['division'] = $value;
        } else {
            $this->attributes['division'] = null;
        }
    }

}
