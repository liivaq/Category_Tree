<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Repositories\SectionRepository;
use Doctrine\DBAL\Exception;

class DeleteSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $id)
    {
        $section = $this->sectionRepository->findById($id);
        $this->sectionRepository->delete($section);
    }

}