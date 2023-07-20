<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Models\Section;
use App\Repositories\SectionRepository;
use App\Services\Section\Requests\CreateSectionRequest;

class CreateSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function execute(CreateSectionRequest $request)
    {
        $section = new Section(
            $request->getTitle(),
            $request->getDescription(),
            $request->getParentId()
        );

        $this->sectionRepository->store($section);
    }

}