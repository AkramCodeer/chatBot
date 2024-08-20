<?php

namespace App\Http\Controllers\Api\V2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V2\Auth\UpdateRequest;
use LaravelJsonApi\Core\Document\Error;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UpdateController extends JsonApiController
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\Api\V2\Auth\UpdateRequest $request
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|\LaravelJsonApi\Core\Document\Error
     * @throws \Exception
     */
    public function __invoke(UpdateRequest $request, int $id): Response|Error
    {
        $user = User::findOrFail($id);

        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone_number'  => $request->phone_number,
            'company_name'  => $request->company_name,
            'dob'           => $request->dob,
        ]);

        return response()->json(['message' => 'User updated successfully'], Response::HTTP_OK);
    }
}