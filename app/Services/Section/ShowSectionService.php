<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Repositories\SectionRepository;

class ShowSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function execute(int $id)
    {
        return $this->sectionRepository->findById($id);
    }

}