<?php

namespace App\Framework;

use PDO;
use PDOException;

use App\Data\Database;

abstract class Repository
{
    protected $connection;

    function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();

        if (!$this->connection) {
            throw new \Exception("❌ Failed to connect to the database.");
        }
    }

    protected function queryExecution($query, $params = array(), $fetchAll = true, $returnLastInsertId = false)
    {
        try {
            $stmt = $this->connection->prepare($query);
            $this->bindValuesToQuery($stmt, $params);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            if ($rowCount == 0) {
                return $this->handleZeroRowCount($query);
            } else if ($rowCount > 0) {
                return $this->handlePositiveRowCount($query, $stmt, $fetchAll, $returnLastInsertId);
            }
        } catch (PDOException $e) {
            throw new \Exception("Query Execution Failed");
        }
    }

    private function handleZeroRowCount($query): ?bool
    {
        if (!stripos($query, 'insert') !== false || stripos($query, 'delete') !== false || stripos($query, 'update') !== false) {
            return false;
        }
        return null;
    }

    private function handlePositiveRowCount($query, $stmt, $fetchAll, $returnLastInsertId)
    {
        if (stripos($query, 'delete') !== false || stripos($query, 'update') !== false || stripos($query, 'insert') !== false) {
            if ($returnLastInsertId) {
                return $this->connection->lastInsertId();
            }
            return true;
        } else {
            if (stripos($query, 'select') !== false) {
                if ($fetchAll) {
                    return $stmt->fetchAll();
                } else {
                    return $stmt->fetch();
                }
            }
        }
    }

    private function bindValuesToQuery($stmt, $params): void
    {
        if (empty($params)) {
            return;
        }
        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
    }

    protected function constructPaginationClause($limit, $offset): ?array
    {
        if (isset($limit) && isset($offset)) {
            return [
                'query' => 'LIMIT :limit OFFSET :offset',
                'parameters' => [':limit' => $limit, ':offset' => $offset]
            ];
        }
        return null;
    }
}