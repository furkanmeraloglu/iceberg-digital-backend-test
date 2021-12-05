<?php

namespace App\Http\Requests;

use ArondeParon\RequestSanitizer\Sanitizers\FilterVars;
use ArondeParon\RequestSanitizer\Sanitizers\Lowercase;
use ArondeParon\RequestSanitizer\Sanitizers\Trim;
use ArondeParon\RequestSanitizer\Traits\SanitizesInputs;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:10'
        ];
    }
}
