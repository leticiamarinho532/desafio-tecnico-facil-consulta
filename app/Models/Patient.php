<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'paciente';

    protected $fillable = ['nome', 'cpf', 'celular'];

    /**
     * Get the comments for the blog post.
     */
    public function doctor(): HasMany
    {
        return $this->hasMany(DoctorPatient::class);
    }

}
