<?php
namespace CodeForms\Repositories\Favorite;

use Illuminate\Database\Eloquent\Model;
/**
 *  @package CodeForms\Repositories\Favorite
 */
class Favorite extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'favorites';

	/**
	 * @var array
	 */
	protected $fillable = ['user_id'];

	/**
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($favorite) {
            $favorite->user_id = auth()->user()->id;
        });
    }

    /**
     * 
     */
	public function favoriteable()
	{
		return $this->morphTo();
	}
}