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
<?php
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
<?php
$post = Post::find(1);

$post->hasFavorite(); // ilgili $post için mevcut kullanıcının (auth()->user()) favori kaydını sorgular
$post->addFavorite(); // ilgili $post'u mevcut kullanıcı için 'favori' olarak kaydeder
$post->unFavorite(); // ilgili $post'un mevcut kullanıcıya ait 'favori' kaydını siler
$post->toggleFavorite(); // ilgili $post için kullanıcının 'favori' kaydı varsa siler, yoksa yeni bir kayıt oluşturur
$post->deleteFavorites(); // $post'a ait tüm favori kayıtlarını siler
$post->favorites()->count(); // $post'u favori olarak kaydeden toplam kullanıcı/kayıt sayısı
``` 
---
* (Tercihen) UserFavorites trait dosyasını ```User``` model'a ekleyin;
UserFavorites trait dosyası, kullanıcıların favori olarak kaydettiği kayıtları object olarak almayı sağlar.
```php
<?php
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
<?php
$user = User::find(1);

$user->favorites(); // bir kullanıcının tüm favori kayıtlarını object olarak alır
$user->hasFavorite(); // bir kullanıcının favori kaydını sorgular
$user->deleteFavorites(); // bir kullanıcıya ait tüm favori kayıtlarını siler
``` 