<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\ReportArticleComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ReportArticleCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportArticleComment::class);
    }

    public function callArticleCommentReportProcedure(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $sql = 'CALL generateArticleCommentReport';
        $stmt = $connection->query($sql);
        $stmt->execute();
    }
}
