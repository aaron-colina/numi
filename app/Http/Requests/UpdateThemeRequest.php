<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThemeRequest extends FormRequest
{

    protected $colorFields = [
        'primary_color',
        'secondary_color',
        'canvas_color',
        'primary_surface_color',
        'secondary_surface_color',
        'primary_border_color',
        'secondary_border_color',
        'light_text_color',
        'dark_text_color',
        'danger_color',
        'info_color',
        'warning_color',
        'success_color',
        'highlight_color'
    ];

    protected $fontFields = ['main_font', 'mono_font'];

    protected $typographyArrays = [
        'h1_typography',
        'h2_typography',
        'h3_typography',
        'h4_typography',
        'h5_typography',
        'h6_typography',
        'label_typography',
        'body_typography'
    ];

    protected $sizeFields = ['border_radius'];

    protected $shadowFields = ['shadow_sm', 'shadow_md', 'shadow_lg'];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['string', 'nullable', 'max:255'],
        ];

        // Add color field rules
        foreach ($this->colorFields as $field) {
            $rules[$field] = ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{8})$/'];
        }

        // Add font field rules
        foreach ($this->fontFields as $field) {
            $rules[$field] = ['nullable', 'string', 'max:64'];
        }

        // Add typography array rules with key-specific validation
        foreach ($this->typographyArrays as $field) {
            $rules[$field] = ['nullable', 'array', 'size:3'];
            $rules["{$field}.0"] = ['required', 'string', 'regex:/^\d+(\.\d+)?(px|rem|em)$/']; // size
            $rules["{$field}.1"] = ['required', 'string', 'max:64']; // font
            $rules["{$field}.2"] = ['required', 'string', 'max:3']; // weight
        }

        // Add size fields rules
        foreach ($this->sizeFields as $field) {
            $rules[$field] = ['nullable', 'string', 'max:4'];
        }

        // Add shadow field rules
        foreach ($this->shadowFields as $field) {
            $rules[$field] = ['nullable', 'string', 'max:64'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [
            // Basic string field messages
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name cannot be longer than 255 characters.',
        ];

        // Add color field messages
        foreach ($this->colorFields as $field) {
            $fieldName = $this->getReadableFieldName($field);
            $messages["{$field}.regex"] = "The {$fieldName} must be a valid hex color (e.g., #FF0000 or #FF0000FF).";
        }

        // Add font field messages
        foreach ($this->fontFields as $field) {
            $fieldName = $this->getReadableFieldName($field);
            $messages["{$field}.max"] = "The {$fieldName} cannot be longer than 64 characters.";
        }

        // Add typography array messages
        foreach ($this->typographyArrays as $field) {
            $fieldName = $this->getReadableFieldName($field);
            
            $messages["{$field}.array"] = "The {$fieldName} must be an array.";
            $messages["{$field}.size"] = "The {$fieldName} must contain exactly 3 elements: [size, font, weight].";
            
            // Key-specific messages
            $messages["{$field}.0.required"] = "The size is required in {$fieldName}.";
            $messages["{$field}.0.string"] = "The size in {$fieldName} must be a string.";
            $messages["{$field}.0.regex"] = "The size in {$fieldName} must be a valid CSS size (e.g., 16px, 1.5rem, 1.2em).";
            
            $messages["{$field}.1.required"] = "The font is required in {$fieldName}.";
            $messages["{$field}.1.string"] = "The font in {$fieldName} must be a string.";
            $messages["{$field}.1.max"] = "The font in {$fieldName} cannot be longer than 64 characters.";
            
            $messages["{$field}.2.required"] = "The weight is required in {$fieldName}.";
            $messages["{$field}.2.string"] = "The weight in {$fieldName} must be a string.";
            $messages["{$field}.2.max"] = "The weight in {$fieldName} cannot be longer than 3 characters.";
        }

        // Add size field messages
        foreach ($this->sizeFields as $field) {
            $fieldName = $this->getReadableFieldName($field);
            $messages["{$field}.max"] = "The {$fieldName} cannot be longer than 4 characters.";
        }

        // Add shadow field messages
        foreach ($this->shadowFields as $field) {
            $fieldName = $this->getReadableFieldName($field);
            $messages["{$field}.max"] = "The {$fieldName} cannot be longer than 64 characters.";
        }

        return $messages;
    }

    private function getReadableFieldName(string $field): string
    {
        return ucwords(str_replace('_', ' ', $field));
    }
} 