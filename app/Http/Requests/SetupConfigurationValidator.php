<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetupConfigurationValidator extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'db_server' => 'bail|required',
            'db_engine' => 'bail|required',
            'db_name' => 'bail|required',
            'db_username' => 'bail|required',
            'db_hostname' => 'bail|required',
            'db_port' => 'bail|required|numeric',
            'db_password' => 'bail|nullable',
            'table_prefix' => 'bail|required',
            'charset' => 'required',
            'collation' => 'required',
        ];
    }

    public function attributes() {
        return [
            'db_server' => 'database server',
            'db_engine' => 'database engine',
            'db_name' => 'database name',
            'db_username' => 'database username',
            'db_hostname' => 'database host',
            'db_port' => 'database port',
            'db_password' => 'database password',
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute is required.',
            'numeric' => ':attribute must be a number.'
        ];
    }

    public function prepareForValidation() {
        $this->merge([
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);
    }
}
