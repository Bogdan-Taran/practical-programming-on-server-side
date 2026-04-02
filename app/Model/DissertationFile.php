<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DissertationFile extends Model
{
    protected $table = 'dissertation_files';
    protected $primaryKey = 'file_id';

    public $timestamps = false; // Если не используете created_at и updated_at

    protected $fillable = [
        'dissertation_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function dissertation(): BelongsTo
    {
        return $this->belongsTo(Dissertations::class, 'dissertation_id', 'dissertation_id');
    }
}