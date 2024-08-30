<?php

namespace App\Modules\Languages\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Languages\Models\Language;
use Illuminate\Http\Request;
use App\Modules\Languages\Http\Requests\LanguagePostRequest;
use App\Modules\Languages\Services\LanguageService;

class LanguageController extends Controller
{
    private $service;

    public function __construct(LanguageService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->all($request);
    }

    public function store(Request $request, Language $language)
    {
        $user = auth()->user();
        if($user){
            $user = $user->id;

        }
        // else{
        //     $user = 1;
        // }
        return $this->service->store($request, $language, $user);
    }

    public function show(Language $language)
    {
        return $this->service->show($language);

    }

    public function update(Request $request, Language $language)
    {
        $user = auth()->user();
        if($user){
            $user = $user->id;

        }
        // else{
        //     $user = 1;
        // }
        return $this->service->update($request, $language, $user);
    }

    public function destroy(Language $language)
    {
        return $this->service->destroy($language);
    }

}
