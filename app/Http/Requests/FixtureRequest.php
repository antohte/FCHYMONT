<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FixtureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-calendar') ?? false;
    }

    public function rules(): array
    {
        return [
            'opponent_name' => ['required', 'string', 'max:120'], 'match_date' => ['required', 'date_format:Y-m-d'],
            'kickoff_time' => ['nullable', 'date_format:H:i'], 'competition' => ['required', 'string', 'max:120'], 'venue' => ['nullable', 'string', 'max:160'],
            'is_home' => ['required', 'boolean'], 'is_published' => ['required', 'boolean'],
            'outcome' => ['nullable', 'prohibited_unless:status,finished', Rule::in(['win', 'draw', 'loss'])],
            'status' => ['required', Rule::in(['scheduled', 'finished', 'postponed', 'cancelled'])],
            'club_score' => [Rule::requiredIf(fn () => $this->input('status') === 'finished' && ! $this->filled('outcome')), 'required_with:opponent_score', 'prohibited_unless:status,finished', 'nullable', 'integer', 'min:0', 'max:99'],
            'opponent_score' => [Rule::requiredIf(fn () => $this->input('status') === 'finished' && ! $this->filled('outcome')), 'required_with:club_score', 'prohibited_unless:status,finished', 'nullable', 'integer', 'min:0', 'max:99'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être un texte.',
            'max.string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
            'date_format' => 'Le champ :attribute doit respecter le format :format.',
            'boolean' => 'Le choix :attribute est invalide.',
            'in' => 'La valeur du champ :attribute est invalide.',
            'required_if' => 'Renseignez le :attribute pour un match terminé.',
            'prohibited_unless' => 'Le :attribute doit rester vide tant que le match n’est pas terminé.',
            'integer' => 'Le :attribute doit être un nombre entier.',
            'min.numeric' => 'Le :attribute doit être au moins égal à :min.',
            'max.numeric' => 'Le :attribute ne doit pas dépasser :max.',
        ];
    }

    public function attributes(): array
    {
        return ['opponent_name' => 'adversaire', 'match_date' => 'date du match', 'kickoff_time' => 'heure', 'competition' => 'compétition', 'venue' => 'lieu', 'club_score' => 'score du FC Hymont', 'opponent_score' => 'score adverse'];
    }
}
