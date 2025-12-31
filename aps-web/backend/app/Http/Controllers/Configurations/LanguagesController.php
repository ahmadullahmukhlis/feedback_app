<?php

namespace App\Http\Controllers\Configurations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configurations\LanguageRequest;
use App\Http\Resources\Configurations\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function index(Request $request ){
        return LanguageResource::collection(
            Language::query()->get()
        );
    }

    public function store(LanguageRequest $request ){
        $this->allowed('languages-create');
        $data = $request->validated();
        Language::query()->create($data);
        return response()->json([
            'result' => true,
            'message' => 'Language created successfully'
        ]);
    }

    public function destroy(Request $request, Language $language ){
        $this->allowed('languages-delete');
        if($language->words->count() > 0)
            return response()->json([
                'result' => false,
                'message' => 'Language cannot be deleted'
            ]);
        $language->delete();
        return response()->json([
            'result' => true,
            'message' => 'Languages deleted successfully'
        ]);
    }

    public function languageWords(Request $request ){
        $lang_abbr = $request->header('lang');
        if($lang_abbr == 'eng') return [];
        else{
            return cache()->remember('language-'.$lang_abbr, 60*30*60, function() use ($lang_abbr){
                $lang = Language::query()
                    ->with('words')
                    ->where('abbr', $lang_abbr)->firstOrFail();
                $words = [];
                foreach ($lang->words as $word){
                    $words[preg_replace('!\s+!','',str_replace(' ','-',strtolower($word->word)))] = $word->translation;
                }
                return $words;
            });
        }
    }
}
