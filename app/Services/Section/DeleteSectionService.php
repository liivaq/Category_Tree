<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Repositories\SectionRepository;

class DeleteSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function execute(int $id)
    {
        $section = $this->sectionRepository->findById($id);
        $this->sectionRepository->delete($section);
    }

}