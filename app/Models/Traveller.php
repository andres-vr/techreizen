<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Traveller extends Model
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'travellers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'zip_id',
        'major_id',
        'first_name',
        'last_name',
        'email',
        'country',
        'address',
        'gender',
        'phone',
        'emergency_phone_1',
        'emergency_phone_2',
        'nationality',
        'birthdate',
        'birthplace',
        'iban',
        'bic',
        'medical_issue',
        'medical_info',
    ];

    /**
     * Default values for attributes
     *
     * @var array
     */
    protected $attributes = [
        'iban' => 'BE00000000000000',
        'bic' => 'GEBABEBB',
        'medical_issue' => 0,
        'medical_info' => '',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'medical_issue' => 'boolean',
        ];
    }

    /**
     * Get the user associated with this traveller.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the trip associated with the traveller.
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Get the education related to this traveller.
     */
    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id', 'id');
    }

    /**
     * Get the major related to this traveller.
     */
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'id');
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
