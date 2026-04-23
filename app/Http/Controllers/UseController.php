<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UseController extends Controller
{
    function index()
    {
        $users = [
            ['id' => 1, 'name' => "osama"],
            ['id' => 2, 'name' => "omar"],
            ['id' => 3, 'name' => "ahmad"],

        ];
        // foreach ($users as $user) {
        //     echo $user['id'] .' '. $user['name']."\n";
        // }

        return response()->json(["name" => "osama"]);
    }
    public  function CheckUser($id)
    {

        if ($id < 10) {
            return response()->json(["message" => "available"]);
        } else {
            return response()->json(["message" => "NOT available"],403);
        }

        return response()->json($id);
    }
}
