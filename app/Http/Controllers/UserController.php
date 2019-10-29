<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function store(Request $request) {

    	$data = $request->validate([
        	'name' => ['required', 'string', 'max:255'],
        	'email' => ['required', 'email', 'unique:users'],
        	'phone' => ['required', 'string', 'regex:/^\(\d{3}\)\-\d{3}\-\d{4}$/'],
        	'address' => ['required', 'string', 'max:255'],
        	'zipCode' => ['required', 'string', 'regex:/^\d{5}$/'],
        	'file' => ['required', 'mimetypes:image/jpeg,image/png,image/gif,application/pdf,application/msword']
    	]);

    	$fileName = $request->file->store('files');
    	$data['file'] = $fileName;
    	
    	User::create([
    		'name' => $data['name'],
    		'email' => $data['email'],
    		'phone' => $data['phone'],
    		'address' => $data['address'],
    		'zipCode' => $data['zipCode'],
    		'file' => $data['file']
    	]);

    	return 'Record successfully created!';
    	
    }
}
