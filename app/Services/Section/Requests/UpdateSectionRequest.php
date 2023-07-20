<?php declare(strict_types=1);

namespace App\Services\Section\Requests;

class UpdateSectionRequest
{
    private string $title;
    private string $description;
    private int $id;

    public function __construct(array $input)
    {
        $this->title = $input['title'];
        $this->description = $input['description'];
        $this->id = (int) $input['id'];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getId(): int
    {
        return $this->id;
    }


}