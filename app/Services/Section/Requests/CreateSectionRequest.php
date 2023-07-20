<?php declare(strict_types=1);

namespace App\Services\Section\Requests;

class CreateSectionRequest
{
    private string $title;
    private string $description;
    private ?int $parentId;

    public function __construct(array $input)
    {
        $this->title = $input['title'];
        $this->description = $input['description'];
        $this->parentId = $input['parent_id'] ? (int) $input['parent_id'] : null;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

}