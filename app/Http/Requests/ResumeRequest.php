<?php

namespace App\Http\Requests;

use App\Exceptions\ApiFailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
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
            'personal_profile.phone_number' => 'nullable|string|max:255',
            'personal_profile.city' => 'nullable|string|max:255',
            'personal_profile.country' => 'nullable|string|max:255',
            'personal_profile.summary' => 'nullable|string',
            'education' => 'nullable|array',
            'education.*.year' => 'required|string',
            'education.*.degree' => 'required|string|max:255',
            'education.*.school' => 'required|string|max:255',
            'expertise' => 'nullable|array',
            'expertise.*.name' => 'required|string|max:255',
            'skills_and_experience' => 'nullable|array',
            'skills_and_experience.*.year' => 'required|string',
            'skills_and_experience.*.organization' => 'required|string|max:255',
            'skills_and_experience.*.job' => 'required|string|max:255',
            'skills_and_experience.*.title' => 'required|string|max:255',
            'skills_and_experience.*.description' => 'nullable|string',
            'courses' => 'nullable|array',
            'courses.*.year' => 'required|string',
            'courses.*.name' => 'required|string|max:255',
            'extra_curricular_activities' => 'nullable|array',
            'extra_curricular_activities.*' => 'required|string|max:255',
            'languages' => 'nullable|array',
            'languages.*' => 'required|string|max:255',
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'required|string|max:255',
            'certificates' => 'nullable|array',
            'certificates.*.year' => 'required|string',
            'certificates.*.authority' => 'required|string|max:255',
            'certificates.*.title' => 'required|string|max:255',
            'certificates.*.title' => 'required|string|max:255',
            'custom_sections' => 'nullable|array',
            'custom_section.*.title' => 'required|string|max:255',
            'custom_section.*.description' => 'required|string|max:255',
            'certificates.*.header' => 'required|string|max:255',
            'certificates.*.title' => 'required|string|max:255',
            'certificates.*.description' => 'required|string|max:255',
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
