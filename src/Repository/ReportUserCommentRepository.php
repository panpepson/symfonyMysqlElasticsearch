<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\ReportUserComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ReportUserCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportUserComment::class);
    }

    public function callUserCommentReportProcedure(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $sql = 'CALL generateUserCommentReport';
        $stmt = $connection->query($sql);
        $stmt->execute();
    }
}
