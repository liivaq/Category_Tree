<?php declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Core\Session;
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
            ->where('user_id ='.Session::get('user_id'))
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
                'parent_id' => ':parentId',
                'user_id' => ':userId'
            ])
            ->setParameter('title', $section->getTitle())
            ->setParameter('description', $section->getDescription())
            ->setParameter('parentId', $section->getParentId())
            ->setParameter('userId', $section->getUserId())
            ->executeStatement();
    }

    public function update(Section $section)
    {
        $this->connection
            ->createQueryBuilder()
            ->update('sections')
            ->set('title', ':title')
            ->set('description', ':description')
            ->setParameter('title', $section->getTitle())
            ->setParameter('description', $section->getDescription())
            ->where('id = '.$section->getId())
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
            $section->user_id,
            $section->parent_id,
            $section->id,
        );
    }

}