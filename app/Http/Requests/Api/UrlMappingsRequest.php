<?php
declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Rules\NonSelfReferencing;
use App\Service\Url\UrlValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UrlMappingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'urls' => ['required', 'array'],
            'urls.*.url' => ['required', 'string', 'distinct', new NonSelfReferencing()],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $urlValidator = resolve(UrlValidator::class);
                assert($urlValidator instanceof UrlValidator);

                $errors = $urlValidator->validate($this->get('urls'));
                foreach ($errors as $key => $message) {
                    $validator->errors()->add($key, $message);
                }
            }
        ];
    }
}
