<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorPatient extends Model
{
    use HasFactory;

    protected $table = 'medico_paciente';

    protected $fillable = ['medico_id', 'paciente_id'];

    /**
     * Retorna o médico relacionado.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'medico_id');
    }

    /**
     * Retorna o paciente relacionado.
     */
    public function patient(): array
    {
        return [
            'nome' => 'teste',
            'cpf' => '000.000.000-00',
            'celular' => '(00)00000-0000'
        ];
    }
}
