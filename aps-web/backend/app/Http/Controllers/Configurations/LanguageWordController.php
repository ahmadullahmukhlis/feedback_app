<?php

namespace App\Http\Controllers\Configurations;

use App\Events\LanguageWordUpdateEvent;
use App\Helpers\DatatableBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Configurations\LanguageRequest;
use App\Http\Requests\Configurations\LanguageWordRequest;
use App\Http\Resources\Configurations\LanguageWordResource;
use App\Models\Language;
use App\Models\LanguageWord;
use Illuminate\Http\Request;

class LanguageWordController extends Controller
{
    public function index(Request $request){
        $this->allowed('languages-accss');
        $query = LanguageWord::query()->where('language_id', $request->get('language_id'));
        $datatable = new DatatableBuilder($query, ['word', 'translation']);
        return LanguageWordResource::collection($datatable->build());
    }

    public function store(LanguageWordRequest $request ){
        $this->allowed('language-dictionary-add-word');
        $data = $request->validated();
        LanguageWord::query()->create($data);
        $language = Language::query()->find($request->get('language_id'));
        cache()->forget('language-'.$language->abbr);
        event(new LanguageWordUpdateEvent());
        return response()->json([
            'result' => true,
            'message' => 'Language dictionary added successfully'
        ]);
    }

    public function update($languageWord, LanguageWordRequest $request){
        $this->allowed('language-dictionary-add-word');
        $data = $request->validated();
        unset($data['id']);
        $language = Language::query()->find($request->get('language_id'));
        cache()->forget('language-'.$language->abbr);
        LanguageWord::query()->findOrFail($languageWord)->update($data);
        event(new LanguageWordUpdateEvent());
        return response()->json([
            'result' => true,
            'message' => 'Updated'
        ]);
    }

    public function destroy($languageWord){
        $this->allowed('language-dictionary-delete-word');
        $languageWord = LanguageWord::query()->findOrFail($languageWord);
        $language = Language::query()->find($languageWord->language_id);
        cache()->forget('language-'.$language->abbr);
        $languageWord->delete();
        event(new LanguageWordUpdateEvent());
        return response()->json([
            'result' => true,
            'message' => 'Language dictionary deleted successfully'
        ]);
    }
}
