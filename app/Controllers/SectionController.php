<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use App\Core\Session;
use App\Services\Section\CreateSectionService;
use App\Services\Section\DeleteSectionService;
use App\Services\Section\IndexSectionService;
use App\Services\Section\Requests\CreateSectionRequest;
use App\Services\Section\ShowSectionService;

class SectionController
{
    private CreateSectionService $createSectionService;
    private IndexSectionService $indexSectionService;
    private ShowSectionService $showSectionService;
    private DeleteSectionService $deleteSectionService;

    public function __construct(
        IndexSectionService  $indexSectionService,
        CreateSectionService $createSectionService,
        ShowSectionService   $showSectionService,
        DeleteSectionService $deleteSectionService
    )
    {
        $this->createSectionService = $createSectionService;
        $this->indexSectionService = $indexSectionService;
        $this->showSectionService = $showSectionService;
        $this->deleteSectionService = $deleteSectionService;
    }

    public function index(): Response
    {
        if (!Session::has('user_id')) {
            return new Redirect('/');
        }

        $sections = $this->indexSectionService->execute();

        $treeSections = $this->buildTree($sections);

        return new View('dashboard', ['sections' => $treeSections]);
    }

    public function create(array $vars): View
    {
        $parentId = $vars['id'] ?? null;

        $parent = null;

        if ($parentId) {
            $parent = $this->showSectionService->execute((int)$parentId);
        };

        return new View('sections/create', [
            'parent' => $parent
        ]);
    }

    public function store(): Redirect
    {

        $this->createSectionService->execute(new CreateSectionRequest($_POST));
        return new Redirect('/dashboard');
    }

    public function delete(array $vars): Redirect
    {
        $sectionId = (int)$vars['id'];

        $this->deleteSectionService->execute($sectionId);

        return new Redirect('/dashboard');
    }

    private function buildTree(array $elements, $parentId = 0): array
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element->getParentId() == $parentId) {
                $children = $this->buildTree($elements, $element->getId());
                if ($children) {
                    $element->setChildren($children);
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

}