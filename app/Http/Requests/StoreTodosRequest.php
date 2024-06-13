<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoretodosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                    'title' => 'required|string|max:255'
                ];
            }
            protected function failedValidation(Validator $validator)
            {
                throw new HttpResponseException(response()->json([
                    'code' => Response::HTTP_BAD_REQUEST,
                    'error' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST));
            }
    }

