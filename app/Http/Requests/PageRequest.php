<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $request = 6;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $request = $this->request;
        return [
            'title' => 'required|max:255',
            'path' => ['nullable', 'string', Rule::unique('pages')->where(function ($query) use ($request) {
                return $query->where('lang', $request->get('lang'));
            })],
            'type' => 'required'
        ];
    }
}
