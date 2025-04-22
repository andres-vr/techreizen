<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'login',
        'name',
        'email',
        'password',
        'role',
        'first_name',
        'last_name',
        // Additional fields
        'phone',
        'emergency_contact',
        'optional_emergency_contact',
        'medical_info',
        'medical_details',
        'gender',
        'nationality',
        'date_of_birth',
        'place_of_birth',
        'address',
        'city',
        'country',
        'trip',
        'student_number',
        'education',
        'major',
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
     * Get the traveller associated with the user.
     */
    public function traveller()
    {
        return $this->hasOne(Traveller::class);
    }
}
