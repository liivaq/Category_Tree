<?php declare(strict_types=1);

namespace App\Core\Response;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View implements Response
{

    private string $templatePath;
    private array $content;

    public function __construct(string $templatePath, array $content = [])
    {
        $this->templatePath = $templatePath;
        $this->content = $content;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function getContent(): array
    {
        return $this->content;
    }

}