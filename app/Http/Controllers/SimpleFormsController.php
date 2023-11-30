<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Helpers\DebugNotificationHelper;
use App\Helpers\LoggerHelper;
use App\Mail\ManagerMailService;
use App\Traits\CommonResponsesTrait;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SimpleFormsController
{
    protected array $params;

    use CommonResponsesTrait;

    /**
     * Метод получения шаблонов вёрстки для стандартных форм
     * @param string $code
     * @return Application|Factory|View
     */
    public function getForm(string $code)
    {
        $this->prepare($code);
        return view($this->params['form_view']);
    }

    protected function prepare(string $code): void
    {
        $this->params = CommonHelper::getPreset('forms.' . $code);
        abort_if(!$this->params, 404);
    }

    /**
     * Метод отправки стандартных форм
     * @param Request $request
     * @param string $code
     * @return JsonResponse
     */
    public function sendForm(Request $request, string $code): JsonResponse
    {
        $this->prepare($code);
        $validator = Validator::make($request->all(), $this->params['rules'], $this->params['messages']);

        if ($validator->fails()) {
            return $this->responseFail(
                collect($validator->errors()->messages())->map(fn($error, $name) => $error[0])->toArray()
            );
        }

        try {
            $payload = $validator->validated();
            $mailer = new ManagerMailService();
            $method = $this->params['mail_method'];
            $mailer->$method($payload, $this->params['subject'], $this->params['letter_view']);
        } catch (Exception $e) {
            LoggerHelper::debug(json_encode($validator->validated(), JSON_UNESCAPED_UNICODE));
            LoggerHelper::commonErrorVerbose($e);
            DebugNotificationHelper::sendVerboseErrorEmail($e);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->responseOk();
    }
}
