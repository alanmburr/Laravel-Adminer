<?php namespace AlanMBurr\LaravelAdminer;

use Illuminate\Routing\Controller;

class AdminerController extends Controller {

    public function index()
    {
        require('adminer-4.8.1-en.php');
        return new EmptyResponse();
    }

}
