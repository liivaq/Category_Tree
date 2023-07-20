<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Repositories\SectionRepository;
use App\Services\Section\Requests\UpdateSectionRequest;

class UpdateSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function execute(UpdateSectionRequest $request)
    {
        $section = $this->sectionRepository->findById($request->getId());

        $section->setTitle($request->getTitle());
        $section->setDescription($request->getDescription());


        $this->sectionRepository->update($section);
    }

}