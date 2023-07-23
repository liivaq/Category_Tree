<?php declare(strict_types=1);

namespace App\Models;

class Section
{
    private string $title;
    private string $description;
    private array $children = [];
    private int $userId;

    private ?int $parentId;
    private ?int $id;

    public function __construct(
        string $title,
        string $description,
        int $userId,
        ?int   $parentId,
        ?int   $id = null
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->userId = $userId;
        $this->id = $id;
        $this->parentId = $parentId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setTitle(string $title):void
    {
        $this->title = $title;
    }

    public function setDescription(string $description):void
    {
        $this->description = $description;
    }

    public function setParentId(int $id): void
    {
        $this->parentId = $id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'parent_id' => $this->getParentId(),
            'title' => $this->getTitle(),
            'description' =>$this->getDescription(),
        ];
    }

}