<?php

namespace App\Http\Controllers;

use App\Enums\ClientRoutes;
use App\Enums\ModalValidation;
use App\Helpers\CommonHelper;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Character;
use App\Models\Origin;
use App\Models\Race;
use App\Services\ArticlesService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    public function validateForm(FormRequest $request)
    {
        $formData = $request->input('item');
        if ($formData['modal_id'] === ModalValidation::SEO_MODAL->value && $formData['url']) {
            $formData['url'] = Str::finish(Str::start($formData['url'], '/'), '/');
        }

        $rules = ModalValidation::from($formData['modal_id'])->getRules();
        $messages = ModalValidation::from($formData['modal_id'])->getMessages();

        $validator = Validator::make($formData, $rules, $messages);

        if ($validator->fails()) {
            $errors = collect($validator->messages()->messages())->map(fn($error, $name) => $error[0])->toArray();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        return response()->json(['success' => true]);
    }

    public function getRaceData()
    {
        $race = Race::query()->active()->with('genders', 'chClasses')->get();
        $origins = Origin::query()->active()->get();

        $data = [
            'race' => $race,
            'origins' => $origins
        ];

        return response()->json($data);
    }

    public function addCharacter(Request $request)
    {
        $data = $request->all();
        $char = new Character();
        $char->fill($data);
        $char->save();
        return response()->json(['success' => true]);
    }

    public function getCharacters(Request $request)
    {
        $data = $request->input('user_id');
        $characters = Character::query()->where('parent_id', $data)->get();
        return response()->json($characters);
    }
}
