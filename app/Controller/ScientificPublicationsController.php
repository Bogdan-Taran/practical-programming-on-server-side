<?php

namespace Controller;

use Illuminate\Database\Schema\IndexDefinition;
use Model\Editions;
use Model\Indexes;
use Model\Student;
use Src\View;

class ScientificPublicationsController
{
    public function ScientificPublications()
    {
        $editions = Editions::all();
        $indexes = Indexes::all();
        $students = Student::all();
        return (new View())->render('site.scientific_publications',
            [
                'editions' => $editions,
                'indexes' => $indexes,
                'students' => $students,
            ]);
    }

    public function addScientificPublication()
    {

    }
}