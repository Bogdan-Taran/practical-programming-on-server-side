<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{
    protected $table = 'groups_names';
    protected $primaryKey = 'group_name_id';

}