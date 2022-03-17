<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Contact;
use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\JsonResponse;

class ContactController extends BaseController {
    /**
     * @OA\Get(path="contacts", summary="Lista de contatos", tags={"Contacts"},
     *    @OA\Response(description="Listagem dos contatos cadastrados", response="200",
     *      content={
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string", description="Nome do contato", example="John Due"),
     *                  @OA\Property(property="phone", type="string", description="Telefone do contato", example="(41) 992129212)"),
     *                  @OA\Property(property="cpf", type="strig", description="CPF do contato", example="12345678910"),
     *                  @OA\Property(property="address", type="string", description="Endereço do contato", example="Rua Almirante Garnier"),
     *                  @OA\Property(property="number", type="string", description="Número do endereço do contato", example="100"),
     *                  @OA\Property(property="neighborhood", type="string", description="Bairro do contato", example="Bairro Alto"),
     *                  @OA\Property(property="city", type="string", description="Cidade do contato", example="Curitiba"),
     *                  @OA\Property(property="state", type="string", description="Stado do contato", example="Paraná"),
     *                  @OA\Property(property="cep", type="string", description="CEP do contato", example="81100100"),
     *                  @OA\Property(property="latitude", type="string", description="Latitude do endereço do contato", example="-25.441105"),
     *                  @OA\Property(property="longitude", type="string", description="Longitude do endereço do contato", example="-49.276855"),
     *                  @OA\Property(property="type_id", type="integer", description="Id do tipo de contato")
     *              ),
     *          )
     *      },
     *    ),
     *    @OA\Response(response="200", description="Contatos encontrados.")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $contacts = Contact::all();
        return $this->sendResponse(ContactResource::collection($contacts), 'Contatos encontrados.');
    }   
    
    /**
     * @OA\Get(path="contacts/search", summary="Pesquisa de contatos", tags={"Contacts"},
     *    @OA\Response(description="Pesquisa de contatos cadastrados", response="200",
     *    @OA\RequestBody(required=true, description="Cadastro - obrigatório",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="search", type="string", description="Termo a ser encontrado")
     *                  @OA\Property(property="filter", type="string", description="Termo a ser filtrado")
     *              )
     *          )
     *      },
     *      content={
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string", description="Nome do contato", example="John Due"),
     *                  @OA\Property(property="phone", type="string", description="Telefone do contato", example="(41) 992129212)"),
     *                  @OA\Property(property="cpf", type="strig", description="CPF do contato", example="12345678910"),
     *                  @OA\Property(property="address", type="string", description="Endereço do contato", example="Rua Almirante Garnier"),
     *                  @OA\Property(property="number", type="string", description="Número do endereço do contato", example="100"),
     *                  @OA\Property(property="neighborhood", type="string", description="Bairro do contato", example="Bairro Alto"),
     *                  @OA\Property(property="city", type="string", description="Cidade do contato", example="Curitiba"),
     *                  @OA\Property(property="state", type="string", description="Stado do contato", example="Paraná"),
     *                  @OA\Property(property="cep", type="string", description="CEP do contato", example="81100100"),
     *                  @OA\Property(property="latitude", type="string", description="Latitude do endereço do contato", example="-25.441105"),
     *                  @OA\Property(property="longitude", type="string", description="Longitude do endereço do contato", example="-49.276855"),
     *                  @OA\Property(property="type_id", type="integer", description="Id do tipo de contato")
     *              ),
     *          )
     *      },
     *    ),
     *    @OA\Response(response="200", description="Contatos encontrados.")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse {
        $term = $request->input('term');
        $filter = $request->input('filter');
        $contacts = Contact::where(function ($query) use ($filter) {
            if ($filter > 0) $query->where('type_id', intval($filter));
        })
        ->where(function ($query) use ($term) {
            $query->OrWhere('name', 'LIKE', '%'.$term.'%')
            ->OrWhere('cpf', 'LIKE', '%'.$term.'%')
            ->OrWhere('phone', 'LIKE', '%'.$term.'%')
            ->OrWhere('city', 'LIKE', '%'.$term.'%')
            ->OrWhere('state', 'LIKE', '%'.$term.'%');
        })->get();
        return $this->sendResponse(ContactResource::collection($contacts), 'Contatos encontrados.');
    }   
    
    /**
     * @OA\Get(path="contacts/filter", summary="Filtro de tipos de contatos", tags={"Contacts"},
     *    @OA\Response(description="Filtro de contatos cadastrados por tipo", response="200",
     *    @OA\RequestBody(required=true, description="Cadastro - obrigatório",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="term", type="string", description="Termo as ser filtrado")
     *              )
     *          )
     *      },
     *      content={
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string", description="Nome do contato", example="John Due"),
     *                  @OA\Property(property="phone", type="string", description="Telefone do contato", example="(41) 992129212)"),
     *                  @OA\Property(property="cpf", type="strig", description="CPF do contato", example="12345678910"),
     *                  @OA\Property(property="address", type="string", description="Endereço do contato", example="Rua Almirante Garnier"),
     *                  @OA\Property(property="number", type="string", description="Número do endereço do contato", example="100"),
     *                  @OA\Property(property="neighborhood", type="string", description="Bairro do contato", example="Bairro Alto"),
     *                  @OA\Property(property="city", type="string", description="Cidade do contato", example="Curitiba"),
     *                  @OA\Property(property="state", type="string", description="Stado do contato", example="Paraná"),
     *                  @OA\Property(property="cep", type="string", description="CEP do contato", example="81100100"),
     *                  @OA\Property(property="latitude", type="string", description="Latitude do endereço do contato", example="-25.441105"),
     *                  @OA\Property(property="longitude", type="string", description="Longitude do endereço do contato", example="-49.276855"),
     *                  @OA\Property(property="type_id", type="integer", description="Id do tipo de contato")
     *              ),
     *          )
     *      },
     *    ),
     *    @OA\Response(response="200", description="Contatos encontrados.")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse {
        $filter = $request->input('filter');
        $contacts = Contact::where('type_id', $filter)->get();
        return $this->sendResponse(ContactResource::collection($contacts), 'Contatos encontrados.');
    }   

   /**
     * @OA\Post(path="contacts", summary="Cadastro de contatos", tags={"Contacts"},
     *   @OA\RequestBody(required=true, description="Cadastro - obrigatório",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string", description="Nome do contato"),
     *                  @OA\Property(property="phone", type="string", description="Telefone do contato"),
     *                  @OA\Property(property="cpf:unique", type="strig", description="CPF do contato"),
     *                  @OA\Property(property="address", type="string", description="Endereço do contato"),
     *                  @OA\Property(property="neighborhood", type="string", description="Bairro do contato"),
     *                  @OA\Property(property="city", type="string", description="Cidade do contato"),
     *                  @OA\Property(property="state", type="string", description="Stado do contato"),
     *                  @OA\Property(property="cep", type="string", description="CEP do contato"),
     *                  @OA\Property(property="latitude", type="string", description="Latitude do endereço do contato"),
     *                  @OA\Property(property="longitude", type="string", description="Longitude do endereço do contato"),
     *                  @OA\Property(property="type_id", type="integer", description="Id do tipo de contato")
     *              ),
     *          )
     *      },
     *   ),
     *   @OA\RequestBody(required=false, description="Cadastro - opcional",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="number", type="string", description="Número do endereço do contato")
     *              ),
     *          )
     *      },
     *   ),
     *   @OA\Response(response=404, description="Parâmetro inválido."),
     *   @OA\Response(response=500, description="Erro ao cadastrar contato."),
     *   @OA\Response(response="200", description="Contato criado.")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required|celular_com_ddd',
            'cpf' => 'required|unique:contacts|cpf',
            'address' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            'cep' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'type_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $contact = Contact::create($input);
        return $this->sendResponse(new ContactResource($contact), 'Contato criado.');
    }

    /**
     * @OA\Put(path="contacts{id}", summary="Atualizar cadastro de contatos", tags={"Contacts"},
     *   @OA\RequestBody(required=true, description="Atualizar - obrigatório",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string", description="Nome do contato"),
     *                  @OA\Property(property="phone", type="string", description="Telefone do contato"),
     *                  @OA\Property(property="cpf:unique", type="strig", description="CPF do contato"),
     *                  @OA\Property(property="address", type="string", description="Endereço do contato"),
     *                  @OA\Property(property="neighborhood", type="string", description="Bairro do contato"),
     *                  @OA\Property(property="city", type="string", description="Cidade do contato"),
     *                  @OA\Property(property="state", type="string", description="Stado do contato"),
     *                  @OA\Property(property="cep", type="string", description="CEP do contato"),
     *                  @OA\Property(property="latitude", type="string", description="Latitude do endereço do contato"),
     *                  @OA\Property(property="longitude", type="string", description="Longitude do endereço do contato"),
     *                  @OA\Property(property="type_id", type="integer", description="Id do tipo de contato")
     *              ),
     *          )
     *      },
     *   ),
     *   @OA\RequestBody(required=false, description="Atualizar - opcional",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="number", type="string", description="Número do endereço do contato")
     *              ),
     *          )
     *      },
     *   ),
     *   @OA\Response(response=404, description="Parâmetro inválido."),
     *   @OA\Response(response=500, description="Erro ao atualizar contato."),
     *   @OA\Response(response="200", description="Contato atualizado.")
     * )
     * @param Contact $contact
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, Contact $contact) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required|celular_com_ddd',
            'cpf' => 'required|cpf',
            'address' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            'cep' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'type_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $contact->name = $input['name'];
        $contact->phone = $input['phone'];
        $contact->cpf = $input['cpf'];
        $contact->address = $input['address'];
        $contact->number = $input['number'];
        $contact->neighborhood = $input['neighborhood'];
        $contact->city = $input['city'];
        $contact->state = $input['state'];
        $contact->cep = $input['cep'];
        $contact->latitude = $input['latitude'];
        $contact->longitude = $input['longitude'];  
        $contact->type_id = $input['type_id'];        
        $contact->save();        
        return $this->sendResponse(new ContactResource($contact), 'Contato atualizado.');
    }

    /**
     * @OA\Delete(path="contacts/{id}", summary="Excluir contatos", tags={"Contacts"},
     *    @OA\Response(description="Exclusão do contato selecionado", response="200", description="Contato excluído.",
     *      content={
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id", type="string", description="Id do contato")
     *              ),
     *          )
     *      },
     *    ),
     *    @OA\Response(response="200", description="Contato criado.")
     * )
     * @param Contact $contact
     * @return JsonResponse
     */
    public function destroy(Contact $contact) {
        $contact->delete();
        return $this->sendResponse([], 'Contato excluído.');
    }
}
