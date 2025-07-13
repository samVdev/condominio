<?php

namespace App\Http\Controllers;

use App\Http\Requests\Surveys\StoreSurveyRequest;
use App\Http\Requests\Surveys\StoreSurveyResponseRequest;
use App\Http\Services\Surveys\deleteService;
use App\Http\Services\Surveys\getByBoard;
use App\Http\Services\Surveys\getByBoardSurveys;
use App\Http\Services\Surveys\newResponseSurvey;
use App\Http\Services\Surveys\statusChangeService;
use App\Http\Services\Surveys\storeSurveys;
use Illuminate\Http\JsonResponse;

class SurveyController extends Controller
{
    public function byBoard($uuid): JsonResponse
    {
        return getByBoard::index($uuid);
    }

    public function byBoardSurveys($uuid): JsonResponse
    {
        return getByBoardSurveys::index($uuid);
    }

    public function store(StoreSurveyRequest $request, $uuid): JsonResponse
    {
        return storeSurveys::index($request, $uuid);
    }

    public function status($id): JsonResponse
    {
        return statusChangeService::index($id);
    }

    public function response(StoreSurveyResponseRequest $request): JsonResponse
    {
        return newResponseSurvey::index($request);
    }

    public function delete($id): JsonResponse
    {
        return deleteService::index($id);
    }
}
