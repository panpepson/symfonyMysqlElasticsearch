<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200321113845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE PROCEDURE generateUserCommentReport()
                BEGIN
                
                    DELETE FROM report_user_comment;
                    INSERT INTO report_user_comment (firstname, lastname, comment_amount)

                    SELECT 
                        user.firstname, 
                        user.lastname, 
                        COUNT(article_comment.id)
                    FROM user
                        JOIN article_comment ON user.id = article_comment.user_id
                    GROUP BY 
                        user.firstname, 
                        user.lastname;
                            
                END;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP PROCEDURE generateUserCommentReport');
    }
}
