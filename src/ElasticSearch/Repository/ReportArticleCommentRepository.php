<?php
declare(strict_types=1);

namespace App\ElasticSearch\Repository;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FOS\ElasticaBundle\Repository;

class ReportArticleCommentRepository extends Repository
{
    public function search()
    {
        $boolQuery = new BoolQuery();
        $query = Query::create($boolQuery);
        return $this->find($query);
    }
}
