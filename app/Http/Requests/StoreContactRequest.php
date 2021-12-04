<?php

namespace App\Http\Requests;

use ArondeParon\RequestSanitizer\Sanitizers\FilterVars;
use ArondeParon\RequestSanitizer\Sanitizers\Lowercase;
use ArondeParon\RequestSanitizer\Sanitizers\Trim;
use ArondeParon\RequestSanitizer\Traits\SanitizesInputs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreContactRequest extends FormRequest
{
    use SanitizesInputs;

    protected $sanitizers = [
        'name' => [FilterVars::class => ['filter' => FILTER_SANITIZE_STRING]],
        'email' => [Lowercase::class, Trim::class, FilterVars::class => ['filter' => FILTER_SANITIZE_EMAIL]],
        'phone' => [Trim::class, FilterVars::class => ['filter' => FILTER_SANITIZE_STRING]]
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/(01)[0-9]{9}+/|min:10'
        ];
    }

    protected function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
