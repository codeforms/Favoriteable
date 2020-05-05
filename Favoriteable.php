<?php
namespace CodeForms\Repositories\Favorite;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
/**
 * @package CodeForms\Repositories\Favorite
 */
trait Favoriteable
{
	/**
     * @return Illuminate\Database\Eloquent\Model
     */
    public static function bootFavoriteable()
    {
        static::deleted(function (self $model) {
            $model->deleteFavorites();
        });
    }

	/**
	 * @example $post->hasFavorite()
	 * 
	 * @return boolean
	 */
	public function hasFavorite(): bool
	{
		return (bool)$this->favorites()->where('user_id', auth()->user()->id)->first();
	}

	/**
	 * @example $post->addFavorite()
	 * 
	 * @return object|boolean
	 */
	public function addFavorite()
	{
		if(!self::hasFavorite())
			return $this->favorites()->create();
		return false;
	}

	/**
	 * @example $post->removeFavorite()
	 * 
	 * @return mixed
	 */
	public function removeFavorite(): bool
	{
		if(self::hasFavorite())
			return $this->favorites()->where('user_id', auth()->user()->id)->delete();
		return false;
	}

	/**
	 * @example $post->deleteFavorites()
	 * 
	 * @return boolean
	 */
	public function deleteFavorites(): bool
	{
		return $this->favorites()->delete();
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function favorites()
	{
		return $this->morphMany(Favorite::class, 'favoriteable');
	}
}