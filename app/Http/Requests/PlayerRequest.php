<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-calendar') ?? false;
    }

    public function rules(): array
    {
        return [
            'display_name' => ['required', 'string', 'max:80'],
            'first_name' => ['nullable', 'string', 'max:80'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date_format:Y-m-d', 'before_or_equal:today', 'after:1900-01-01'],
            'position' => ['required', Rule::enum(PlayerPosition::class)],
            'position_label' => ['required', 'string', 'max:80'],
            'number' => ['nullable', 'integer', 'between:1,999'],
            'show_goals' => ['sometimes', 'boolean'],
            'show_saves' => ['sometimes', 'boolean'],
            'goals' => ['nullable', 'integer', 'between:0,99999'],
            'saves' => ['nullable', 'integer', 'between:0,99999'],
            'is_published' => ['required', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096', 'dimensions:max_width=6000,max_height=6000'],
            'remove_photo' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Ce champ est obligatoire.', 'string' => 'Saisissez un texte.',
            'max.string' => 'Ne dépassez pas :max caractères.', 'integer' => 'Saisissez un nombre entier.',
            'between.numeric' => 'Saisissez une valeur entre :min et :max.',
            'date_format' => 'Saisissez une date valide au format AAAA-MM-JJ.',
            'before_or_equal' => 'La naissance ne peut pas être dans le futur.',
            'after' => 'La date doit être postérieure au 1er janvier 1900.',
            'boolean' => 'Choisissez une valeur valide.', 'enum' => 'Choisissez un poste proposé.',
            'image' => 'Choisissez une image valide.', 'mimes' => 'Formats acceptés : JPEG, PNG et WebP.',
            'max.file' => 'Le portrait ne doit pas dépasser 4 Mo.', 'dimensions' => 'Le portrait ne doit pas dépasser 6 000 pixels par côté.',
        ];
    }
}
