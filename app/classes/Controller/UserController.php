<?php

namespace App\Controller;

use App\Database\Database;

class UserController extends Controller
{
    public function index()
    {
        $database = Database::getInstance();
        $result = $database->query('SELECT * FROM users WHERE id = ?', [1])->get();
        $message = 'Hello, ' . $result['username'] . '!';
        return view('message', compact('message'));
    }
}
