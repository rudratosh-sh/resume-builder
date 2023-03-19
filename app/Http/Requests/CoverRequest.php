<?php

namespace App\Http\Requests;

use App\Exceptions\ApiFailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CoverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'personal_profile' => 'nullable|array',
            'personal_profile.name' => 'required|string|max:255',
            'personal_profile.job_title' => 'required|string|max:255',
            'personal_profile.email' => 'nullable|string|email|max:255',
            'personal_profile.phone_code' => 'nullable|integer',
            'personal_profile.phone_number' => 'nullable|integer',
            'personal_profile.address' => 'nullable|string|max:255',
            'personal_profile.city' => 'nullable|string|max:255',
            'personal_profile.country' => 'nullable|string|max:255',
            'company_profile' => 'nullable|array',
            'company_profile.*.company_name' => 'required|string',
            'company_profile.*.company_address' => 'required|string|max:255',
            'company_profile.*.company_address_2' => 'string|max:255',
            'greeting' => 'required|string|max:255',
            'introduction' => 'required|string|max:255',
            'why_this_company' => 'required|string|max:255',
            'intention' => 'required|string|max:255',
            'good_fit_thoughts' => 'required|string|max:255',
            'future_goals' => 'required|string|max:255',
            'final_thoughts' => 'required|string|max:255',
            'custom_section' => 'nullable|array',
            'custom_section.*.title' => 'required|string|max:255',
            'custom_section.*.description' => 'required|string|max:255'
        ];
    } 
    
    /**
     * Handle a failed validation attempt for API.
     */
    protected function failedValidation(Validator $validator)
    {
        if (request()->is('api/*')) {
            throw new ApiFailedException($validator->errors());
        }
    }
}
