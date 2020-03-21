<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200321113509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE PROCEDURE generateArticleCommentReport()
                BEGIN
                
                    DELETE FROM report_article_comment;
                    INSERT INTO report_article_comment (article_id, article_title, article_content, comment_amount)

                    SELECT 
                        article.id, 
                        article.title, 
                        article.content, 
                        COUNT(article_comment.id)
                    FROM article
                        JOIN article_comment ON article.id = article_comment.article_id
                    GROUP BY 
                        article.id, 
                        article.title, 
                        article.content;
                            
                END;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP PROCEDURE generateArticleCommentReport');
    }
}
