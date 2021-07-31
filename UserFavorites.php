<?php
namespace CodeForms\Repositories\Favorite;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
/**
 * Trait for user model
 * 
 * @package CodeForms\Repositories\Favorite
 */
trait UserFavorites
{
	/**
	 * @example $user->favorites()
	 * 
	 * @return object|null
	 */
	public function favorites()
	{
		if($this->hasFavorite()) {
			$collection = new Collection;
			foreach($this->userFavorites as $favorite)
				$collection->push(app($favorite->favoriteable_type)->find($favorite->favoriteable_id));

			return $collection;
		}

		return null;
	}

	/**
	 * @example $user->hasFavorite()
	 * 
	 * @return boolean
	 */
	public function hasFavorite(): bool
	{
		return !$this->userFavorites->isEmpty();
	}

	/**
	 * @example $user->deleteFavorites()
	 * 
	 * @return boolean
	 */
	public function deleteFavorites(): bool
	{
		if(self::hasFavorite())
			return $this->userFavorites()->delete();
		return false;
	}

	/**
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function userFavorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }
}