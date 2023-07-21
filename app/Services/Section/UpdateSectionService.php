<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Models\Section;
use App\Repositories\SectionRepository;
use App\Services\Section\Requests\UpdateSectionRequest;
use Doctrine\DBAL\Exception;

class UpdateSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(UpdateSectionRequest $request): Section
    {
        $section = $this->sectionRepository->findById($request->getId());

        $section->setTitle($request->getTitle());
        $section->setDescription($request->getDescription());

        $this->sectionRepository->update($section);

        return $section;
    }

}