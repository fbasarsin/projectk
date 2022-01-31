<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 * @property string $site_url
 * @property string $name
 * @property string $last_name
 * @property string $company_name
 * @property string $email
 * @property string $password
 */
class CompanyRegisterRequest extends FormRequest
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
            "site_url" => 'required',
            "name" => 'required|alpha',
            "last_name" => 'required|alpha',
            "company_name" => 'required|alpha_num',
            "email" => 'required|email|unique:companies,email',
            "password" => 'required|min:8'
        ];
    }
}
