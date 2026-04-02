<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dissertations extends Model{
    protected $table = 'dissertations';
    protected $primaryKey = 'dissertation_id';

    public $timestamps = false;

    protected $fillable = [
        'theme',
        'approval_date',
        'status_id',
        'bak_speciality_id',
        'student_id',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(DissertationStatus::class, 'status_id', 'dissertation_status_id');
    }

    public function bakSpeciality(): BelongsTo
    {
        return $this->belongsTo(BAKSpeciality::class, 'bak_speciality_id', 'bak_speciality_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
