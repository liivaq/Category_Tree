<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Repositories\SectionRepository;
use Doctrine\DBAL\Exception;

class IndexSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(): array
    {
        return $this->sectionRepository->all();
    }

}