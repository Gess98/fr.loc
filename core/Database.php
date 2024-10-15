<?php

namespace PHPFramework;

class Database
{

    // Свойство которое хранит подключение к Db
    protected \PDO $connection;

    // Свойство которое хранит подготовленные запросы
    protected \PDOStatement $stmt;

    public function __construct()
    {
        $dsn = "mysql:host=" . DB_SETTINGS['host'] . ";dbname=" . DB_SETTINGS['database'] . ";charset=" . DB_SETTINGS['charset'];

        try {
            $this->connection = new \PDO($dsn, DB_SETTINGS['username'], DB_SETTINGS['password'], DB_SETTINGS['options']);
        } catch (\PDOException $e) {
            // Логирование ошибки при неудачном подключении к базе данных
            error_log("[" . date('Y-m-d H:i:s') . "] Db Error: {$e->getMessage()}" . PHP_EOL, 3, ERROR_LOGS);
            abort('Db error connection', '500');
        }

        return $this;
    }

    // Метод для подготовки и выполнения запросов
    public function query(string $query, array $params = []): static
    {
        // Подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
        $this->stmt = $this->connection->prepare($query);
        // Запускает подготовленный запрос на выполнение
        $this->stmt->execute($params);
        return $this;
    }

    // Обертка над fetchAll. Возвращает все записи
    public function get(): array|false
    {
        return $this->stmt->fetchAll();
    }

    // Метод для возвращения массива с назначенным ключом (по умолчанию id)
    public function getAssoc($key = 'id')
    {
        $data = [];
        while($row = $this->stmt->fetch()) {
            $data[$row[$key]] = $row;
        }

        return $data;
    }

    // Обертка над fetch. Возвращает одну запись в одномерном массиве
    public function getOne()
    {
        return $this->stmt->fetch();
    }

    public function getColumn()
    {
        return $this->stmt->fetchColumn();
    }

    // Получение всех записей из таблицы $tbl
    public function findAll($tbl): array|false
    {
        $this->query("select * from {$tbl}");
        return $this->stmt->fetchAll();
    }

    // Получение одной записи из таблицы $tbl по ключу $key со значением $value
    public function findOne($tbl, $value, $key='id') 
    {
        $this->query("select * from {$tbl} where $key = ? LIMIT 1", [$value]);
        return $this->stmt->fetch();
    }

    // Получение одной записи из таблицы $tbl по ключу $key со значением $value, если записи нет, то вернет ошибку 404
    public function findOrFail($tbl, $value, $key ='id')
    {
        $res = $this->findOne($tbl, $value, $key);
        if (!$res) {
            abort();
        }
        return $res;
    }

    //Получение id последней вставленной записи
    public function getInsertId(): false|string
    {
        return $this->connection->lastInsertId();
    }

    //Получение количества затронутых колонок последним sql запросом
    public function rowCount():int
    {
        return $this->stmt->rowCount();
    }

    // Инициализация транзакции обертка над PDO::beginTransaction
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    // Фиксирует транзакцию обертка над PDO::commit
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    // Откат транзакции обертка над PDO::rollBack
    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

}
