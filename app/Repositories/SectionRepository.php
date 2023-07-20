<?php declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Section;
use Doctrine\DBAL\Connection;

class SectionRepository
{
    private ?Connection $connection;

    public function __construct()
    {
        $this->connection = Database::connect();
    }

    public function all()
    {
        $sections = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('sections')
            ->fetchAllAssociative();

        $sectionCollection = [];

        foreach ($sections as $section)
        {
            $sectionCollection[] = $this->buildModel((object)$section);
        }

        return $sectionCollection;
    }

    public function store(Section $section)
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('sections')
            ->values([
                'title' => ':title',
                'description' => ':description',
                'parent_id' => ':parentId'
            ])
            ->setParameter('title', $section->getTitle())
            ->setParameter('description', $section->getDescription())
            ->setParameter('parentId', $section->getParentId())
            ->executeStatement();
    }

    public function delete(Section $section)
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('sections')
            ->where('id ='.$section->getId())
            ->executeStatement();
    }


    public function findById(int $id)
    {
        $section = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('sections')
            ->where('id = '.$id)
            ->fetchAssociative();

        return $this->buildModel((object) $section);
    }

    public function buildModel(\stdClass $section)
    {
        return new Section(
            $section->title,
            $section->description,
            $section->parent_id,
            $section->id,
        );
    }

}