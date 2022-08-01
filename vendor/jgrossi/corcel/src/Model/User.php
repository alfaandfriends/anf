<?php

namespace Corcel\Model;

use App\Models\UserHasRoles;
use Corcel\Concerns\AdvancedCustomFields;
use Corcel\Concerns\Aliases;
use Corcel\Concerns\MetaFields;
use Corcel\Concerns\OrderScopes;
use Corcel\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * Class User
 *
 * @package Corcel\Model
 * @author Ashwin Sureshkumar <ashwin.sureshkumar@gmail.com>
 * @author Mickael Burguet <www.rundef.com>
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class User extends Model implements Authenticatable, CanResetPassword
{
    const CREATED_AT = 'user_registered';
    const UPDATED_AT = null;

    use AdvancedCustomFields;
    use Aliases;
    use MetaFields;
    use OrderScopes;
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'users';

    protected $fillable = [
        'display_name',
        'user_nicename',
        'user_login',
        'user_email',
        'user_pass',
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * @var array
     */
    protected $hidden = ['user_pass'];

    /**
     * @var array
     */
    protected $dates = ['user_registered'];

    /**
     * @var array
     */
    protected $with = ['meta'];

    /**
     * @var array
     */
    protected static $aliases = [
        'login' => 'user_login',
        'email' => 'user_email',
        'slug' => 'user_nicename',
        'url' => 'user_url',
        'nickname' => ['meta' => 'nickname'],
        'first_name' => ['meta' => 'first_name'],
        'last_name' => ['meta' => 'last_name'],
        'description' => ['meta' => 'description'],
        'created_at' => 'user_registered',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'login',
        'email',
        'slug',
        'url',
        'nickname',
        'first_name',
        'last_name',
        'avatar',
        'created_at',
    ];

    /**
     * @param mixed $value
     */
    public function setUpdatedAtAttribute($value)
    {
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_author');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->primaryKey;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->attributes[$this->primaryKey];
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        $tokenName = $this->getRememberTokenName();

        return $this->meta->{$tokenName};
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $tokenName = $this->getRememberTokenName();

        $this->saveMeta($tokenName, $value);
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the avatar url from Gravatar
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        // $hash = !empty($this->email) ? md5(strtolower(trim($this->email))) : '';

        // return sprintf('//secure.gravatar.com/avatar/%s?d=mm', $hash);

        $user_id    =   $this->ID;
        $user_photo =   DB::table('user_basic_information')->where('user_id', $user_id)->pluck('user_photo')->first();

        if(!$user_photo){
            $user_photo = 'profile_photo/default-profile-photo.png';
        }

        return $user_photo;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setUpdatedAt($value)
    {
        //
    }

    public function user_has_role()
    {
        return $this->hasMany(UserHasRoles::class, 'user_id');
    }
    
    public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->user_email;
    }
}