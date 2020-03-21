# PHP (Symfony) + MySQL + Elasticsearch integration simple example

This application is a simple proof-of-concept that shows PHP(Symfony), MySQL & Elasticsearch integration with FOSElasticaBundle. Sometimes, you may want to show some complex reports in user view, but generating them is a very time consuming process so, as a result, user experience will not be so good. The idea is to separate the stages of processing and reading the data from each other. In this example, MySQL is responsible for writing and processing user data (producing report table with final data) and Elasticsearch only for returning a collection of documents. By running 2 commands, Symfony calls MySQL stored procedures that generates a complex report and then sends it as JSON document collection into Elasticsearch instance.

![Image 1](http://bartekblog.prv.pl/elasticexample/elastic1.png)
![Image 2](http://bartekblog.prv.pl/elasticexample/elastic2.png)
![Image 3](http://bartekblog.prv.pl/elasticexample/elastic3.png)

# Requirements

- Composer
- PHP
- MySQL
- Elasticsearch

# How to run

- Download project files
- Run **composer install** command in terminal to get all the required dependencies.
- Configure database & elasticsearch credentials in **.env** file.
- Run **setupScript.sh** to automate setup process. The script will: create new project database, migrate all migrations into database and fetch it with some random data generated in fixtures.
- Or you can use below commands in project directory instead:
- **php bin/console doctrine:database:create**
- **php bin/console doctrine:migrations:migrate**
- **php bin/console doctrine:fixtures:load**

# Info

- You may consider to look closely at some project files:
1 - **fos_elastica.yaml** (config/packages/fos_elastica.yaml) - contains basic FOSElasticaBundle configuration with entity mappings (reports that will be persisted into Elasticsearch as JSON documents).

2 - **ReportArticleCommentRepository.php** and **ReportUserCommentRepository** - responsible for calling stored procedures placed in MySQL database.

3 - **Version20200321113509.php** and **Version20200321113845.php** - migration files with SQL queries responsible for creating stored procedures.

4 - **ElasticsearchArticleReportCommand** and **ElasticsearchUserReportCommand** - command files responsible for calling stored procedures and sending processed data into Elasticsearch instance.

# Testing

After fetching database with some random data (by **setupScript.sh** or **php bin/console doctrine:fixtures:load** command) run Symfony commands to generate reports (**php bin/console elasticsearch:user:report** or **php bin/console elasticsearch:article:report**).
