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
		return (bool)$this->favorites()->where('user_id', auth()->user()->id)->count();
	}

	/**
	 * @example $post->addFavorite()
	 * 
	 * @return object|boolean
	 */
	public function addFavorite()
	{
		if(!$this->hasFavorite())
			return $this->favorites()->create();
		return false;
	}

	/**
	 * @example $post->unFavorite()
	 * 
	 * @return mixed
	 */
	public function unFavorite(): bool
	{
		if($this->hasFavorite())
			return $this->favorites()->where('user_id', auth()->user()->id)->delete();
		return false;
	}

	/**
	 * @example $post->toggleFavorite()
	 * 
	 * @return mixed
	 */
	public function toggleFavorite()
	{
		return $this->hasFavorite() ?  $this->unFavorite() : $this->addFavorite();
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