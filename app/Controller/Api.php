<?php

namespace Controller;

use Model\Student;
use Model\Dissertations;
use Model\ScientificPublications;
use Model\User;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class Api
{
    public function index(): void
    {
        (new View())->toJSON([
            'message' => 'Academic Management API',
            'resources' => [
                'students' => '/api/students',
                'dissertations' => '/api/dissertations',
                'publications' => '/api/publications'
            ]
        ]);
    }

    public function students(): void
    {
        $students = Student::all();
        (new View())->toJSON($students->toArray());
    }

    public function dissertations(): void
    {
        $dissertations = Dissertations::with(['status', 'bakSpeciality', 'student'])->get();
        (new View())->toJSON($dissertations->toArray());
    }

    public function publications(): void
    {
        $publications = ScientificPublications::with(['edition', 'index', 'student'])->get();
        (new View())->toJSON($publications->toArray());
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function login(Request $request): void
    {
        if ($request->method !== 'POST') {
            (new View())->toJSON(['error' => 'Method not allowed'], 405);
        }

        $credentials = [
            'login' => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Генерируем токен, если его нет
            if (!$user->token) {
                $user->token = md5(time() . $user->login);
                $user->save();
            }
            (new View())->toJSON(['token' => $user->token]);
        }

        (new View())->toJSON(['error' => 'Invalid credentials'], 401);
    }

    public function profile(): void
    {
        $user = Auth::user();
        (new View())->toJSON($user->toArray());
    }
}
