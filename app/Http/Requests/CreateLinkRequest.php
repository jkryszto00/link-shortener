<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransferObjects\CreateLinkDto;
use App\ValueObjects\ShortCode;
use Illuminate\Foundation\Http\FormRequest;

class CreateLinkRequest extends FormRequest
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

    public function getLink(): CreateLinkDto
    {
        return new CreateLinkDto(
            userId: $this->user()->getKey(),
            title: $this->validated('title'),
            url: $this->validated('destination'),
            shortCode: ShortCode::generate()
        );
    }
}
