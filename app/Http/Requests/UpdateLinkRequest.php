<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransferObjects\UpdateLinkDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'min:3', 'max:255'],
            'destination' => ['required', 'string', 'active_url']
        ];
    }

    public function getLink(): UpdateLinkDto
    {
        return new UpdateLinkDto(
            $this->validated('title'),
            $this->validated('destination'),
        );
    }
}
