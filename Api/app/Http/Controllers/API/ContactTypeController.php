<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ContactType;
use App\Http\Resources\ContactType as ContactTypeResource;
use Illuminate\Http\JsonResponse;

class ContactTypeController extends BaseController {
    /**
     * @OA\Get(path="contacts", summary="Lista de tipos de contato", tags={"Contact types"},
     *    @OA\Response(description="Listagem dos tipos de contato cadastrados", response="200", description="Tipos de contato encontrados.",
     *      content={
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id", type="string", description="Id do tipo"),
     *                  @OA\Property(property="name", type="string", description="Nome do tipo", example="Cliente"),
     *              ),
     *          )
     *      },
     *    ),
     *    @OA\Response(response="200", description="Tipos de contato encontrados.")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $types = ContactType::all();
        return $this->sendResponse(ContactTypeResource::collection($types), 'Tipos de contato encontrados.');
    }
}
