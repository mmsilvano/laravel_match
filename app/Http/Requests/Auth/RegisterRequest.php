<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    private const int MIN_AGE = 18;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, object|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'age' => ['required', 'integer', 'between:'.self::MIN_AGE.',99'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
