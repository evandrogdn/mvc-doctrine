<?php

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Auxiliar para controle de gerenciamento de entidades
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (11/03/2023)
 */
class HelperEntityManager 
{
    /**
     * @var EntityManagerInterface|EntityManager
     */
    public EntityManagerInterface|EntityManager $entityManager;

    /**
     * Configura um gerenciador de entidades para ser consumido no projeto
     *
     * @return EntityManagerInterface
     */
    public function __invoke(): EntityManagerInterface
    {
        if (
            isset($this->entityManager)
            && ($this->entityManager instanceof EntityManagerInterface 
            || $this->entityManager instanceof EntityManager)
        ) {
            return $this->entityManager;
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '../../src/Model'],
            isDevMode: boolval(getenv('DEV_MODE'))
        );

        $connectionConfig = [
            'driver' => 'pdo_pgsql',
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'dbname' => getenv('DB_NAME'),
            'charset' => getenv('DB_CHARSET')
        ];

        $connection = DriverManager::getConnection([...$connectionConfig], $config);

        $this->entityManager = new EntityManager($connection, $config);
        return $this->entityManager;
    }
}