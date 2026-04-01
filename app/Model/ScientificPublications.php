<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScientificPublications extends Model
{
    protected $table = 'scientific_publications';
    protected $primaryKey = 'scientific_publication_id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'edition_id',
        'publication_date',
        'index_id',
        'student_id',
    ];

    public function edition(): BelongsTo
    {
        return $this->belongsTo(Editions::class, 'edition_id', 'edition_id');
    }

    public function index(): BelongsTo
    {
        return $this->belongsTo(Indexes::class, 'index_id', 'index_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
