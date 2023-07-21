<?php declare(strict_types=1);

namespace App\Services\Section;

use App\Core\Session;
use App\Models\Section;
use App\Repositories\SectionRepository;
use App\Services\Section\Requests\CreateSectionRequest;
use Doctrine\DBAL\Exception;

class CreateSectionService
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(CreateSectionRequest $request)
    {
        $section = new Section(
            $request->getTitle(),
            $request->getDescription(),
            (int)Session::get('user_id'),
            $request->getParentId()
        );

        $this->sectionRepository->store($section);
    }

}