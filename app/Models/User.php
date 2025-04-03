<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the email address for password reset.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        // Check if this user is associated with a traveller that has an email
        $traveller = DB::table('travellers')->where('user_id', $this->id)->first();

        if ($traveller && !empty($traveller->email) && strpos($this->login, 'b') === 0) {
            return $traveller->email;
        }

        // Default case - use the login field as email
        return $this->login;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Create a custom notification instance with the token
        $notification = new \Illuminate\Auth\Notifications\ResetPassword($token);

        // Set the URL generation callback to use 'login' instead of 'email'
        $notification->createUrlUsing(function ($notifiable, $token) {
            $clientUrl = config('app.url'); // Get the app URL

            return url(route('password.reset', [
                'token' => $token,
                'login' => $notifiable->getKey(), // Use the user ID instead
            ], false));
        });

        $this->notify($notification);
    }
}
