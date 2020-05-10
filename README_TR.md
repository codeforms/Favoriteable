# Favoriteable
Bir model kaynağını, favorilere ekleme veya hatırlamak için kaydetme gibi farklı kullanım özelliklerinin kolayca uyarlanabilmesine imkan tanıyan, Laravel tabanlı yapılar için basit ve kullanışlı trait yapısı. 

[![GitHub license](https://img.shields.io/github/license/codeforms/Favoriteable)](https://github.com/codeforms/Favoriteable/blob/master/LICENSE)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/codeforms/Favoriteable)
[![stable](http://badges.github.io/stability-badges/dist/stable.svg)](https://github.com/codeforms/Favoriteable/releases)

## Kurulum
* Migration dosyasını kullanarak veri tabanı için gerekli tabloları oluşturun;
``` php artisan migrate```
* Favoriteable trait dosyasını, kullanmak istediğiniz model dosyalarına ekleyiniz;
```php
namespace App\Post;

use CodeForms\Repositories\Favorite\Favoriteable;
use Illuminate\Database\Eloquent\Model;
/**
 * 
 */
class Post extends Model 
{
	use Favoriteable;
}
```
## Kullanım
```php
$post = Post::find(1);

$post->hasFavorite(); // $post'un, mevcut kullanıcı için (auth()->user()) favori kaydını sorgular
$post->addFavorite(); // $post'u, mevcut kullanıcı için (auth()->user()) 'favori' olarak kaydeder
$post->unFavorite(); // $post'un, mevcut kullanıcıya ait (auth()->user()) 'favori' kaydını siler
$post->deleteFavorites(); // $post'a ait tüm favori kayıtlarını siler
``` 
---
* (Tercihen) UserFavorites trait dosyasını ```User``` model'a ekleyin;
UserFavorites trait dosyası, kullanıcıların favori olarak kaydettiği kayıtları object olarak almayı sağlar.
```php
namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use CodeForms\Repositories\Favorite\UserFavorites;

class User extends Authenticatable
{
    use Notifiable, UserFavorites;
```

#### UserFavorites kullanımı
```php
$user = User::find(1);

$user->favorites(); // bir kullanıcının tüm favori kayıtlarını object olarak alır
$user->hasFavorite(); // bir kullanıcının favori kaydını sorgular
$user->deleteFavorites(); // bir kullanıcıya ait tüm favori kayıtlarını siler
``` 