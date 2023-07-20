<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response\JsonResponse;
use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use App\Core\Session;
use App\Services\Section\CreateSectionService;
use App\Services\Section\DeleteSectionService;
use App\Services\Section\IndexSectionService;
use App\Services\Section\Requests\CreateSectionRequest;
use App\Services\Section\Requests\UpdateSectionRequest;
use App\Services\Section\ShowSectionService;
use App\Services\Section\UpdateSectionService;

class SectionController
{
    private CreateSectionService $createSectionService;
    private IndexSectionService $indexSectionService;
    private DeleteSectionService $deleteSectionService;
    private UpdateSectionService $updateSectionService;

    public function __construct(
        IndexSectionService  $indexSectionService,
        CreateSectionService $createSectionService,
        DeleteSectionService $deleteSectionService,
        UpdateSectionService $updateSectionService
    )
    {
        $this->createSectionService = $createSectionService;
        $this->indexSectionService = $indexSectionService;
        $this->deleteSectionService = $deleteSectionService;
        $this->updateSectionService = $updateSectionService;
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


    public function store(): Redirect
    {
        $this->createSectionService->execute(new CreateSectionRequest($_POST));
        return new Redirect('/dashboard');
    }

    public function delete(array $vars): JsonResponse
    {
        $sectionId = (int)$vars['id'];

        $this->deleteSectionService->execute($sectionId);

        return new JsonResponse([
            'success' => true,
        ]);
    }

    public function update(): JsonResponse
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $section = $this->updateSectionService->execute(new UpdateSectionRequest ($data));
        $updatedSection = $section->jsonSerialize();

        return new JsonResponse([
            'success' => true,
            'data' => $updatedSection
        ]);
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