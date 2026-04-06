<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = false;
    protected $fillable = [
        'firstname',
        'lastname',
        'patronymic',
        'specialization_id',
        'group_id',
        'scientific_supervisor_id',
    ];
    
    public static function searchBySupervisorLastName(string $searchQuery): \Illuminate\Database\Eloquent\Collection
    {
        return self::query()
            ->join('users', 'students.scientific_supervisor_id', '=', 'users.user_id')
            ->where('users.lastname', 'like', "%{$searchQuery}%")
            ->select('students.*') // Select all columns from the students table
            ->get();
    }
    public static function getSupervisorByQuery(string $searchQuery): ?User
    {
        return User::query()
            ->where('lastname', 'like', "%{$searchQuery}%")
            ->first();
    }

}