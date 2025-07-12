<?php

    class __Query
    {
        private $__db;
        private $params = [];
        private $query;
        private $read;
        private $table;

        public function __construct($db)
        {
            $this->__db = $db;
            $this->reset();
        }

        public function table($table)
        {
            $this->table = $table;
            return $this;
        }

        public function select($fields = '*' , $as = null)
        {
            $this->query = "SELECT $fields FROM " . $this->table;
            if ($as) {
                $this->query .= " AS $as"; 
            }
            $this->params = [];
            return $this;
        }

        public function selectCount($fields = '*' , $alias = 'Total')
        {   
            $fields = $fields === '*' ? '*' : $fields;
            $this->query = "SELECT COUNT($fields) AS $alias FROM {$this->table}";
            $this->params = [];
            return $this;
        }

        public function join($table, $first, $operator, $second, $type = 'INNER') {
            $this->query .= " $type JOIN $table ON $first $operator $second";
            return $this;
        }

        public function leftJoin($table, $first, $operator, $second) {
            return $this->join($table, $first, $operator, $second, 'LEFT');
        }

        public function rightJoin($table, $first, $operator, $second) {
            return $this->join($table, $first, $operator, $second, 'RIGHT');
        }

        public function fullOuterJoin($table, $first, $operator, $second) {
            return $this->join($table, $first, $operator, $second, 'FULL OUTER');
        }

        public function whereRaw($condition, $parameters = [])
        {
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE ' : ' AND ') . $condition;
            foreach ($parameters as $key => $value) {
                $this->params[":$key"] = $value;
            }
            return $this;
        }

        public function addWhereRaw($condition, $parameters = [])
        {
            if (strpos($this->query, 'WHERE') === false) {
                $this->query .= " WHERE $condition";
            } else {
                $this->query .= " AND $condition";
            }
            foreach ($parameters as $key => $value) {
                $this->params[":$key"] = $value;
            }

            return $this;
        }

        public function whereDate($field, $operator, $date)
        {
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE ' : ' AND ') . "DATE($field) $operator :$field";
            $this->params[":$field"] = $date;
            return $this;
        }

        public function whereIn($field, $values)
        {
            $placeholders = implode(", ", array_map(fn($value) => ":$field" . md5($value), $values));
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE ' : ' AND ') . "$field IN ($placeholders)";
            
            foreach ($values as $i => $value) {
                $this->params[":$field" . md5($value)] = $value;
            }

            return $this;
        }

        public function whereNotIn($field, $values)
        {
            $placeholders = implode(", ", array_map(fn($value) => ":$field" . md5($value), $values));
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE ' : ' AND ') . "$field NOT IN ($placeholders)";
            
            foreach ($values as $i => $value) {
                $this->params[":$field" . md5($value)] = $value;
            }

            return $this;
        }

        public function where($field, $operator = '=', $value = null)
        {
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE ' : ' AND ') . "$field $operator :$field";
            $this->params[":$field"] = $value;
            return $this;
        }

        public function whereNot($field, $operator = '=', $value = null)
        {
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE NOT ' : ' AND NOT ') . "$field $operator :$field";
            $this->params[":$field"] = $value;
            return $this;
        }

        public function whereComplex($column1, $operator1, $value1, $column2, $operator2, $value2)
        {
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE ' : ' AND ') . "($column1 $operator1 :$column1 OR $column2 $operator2 :$column2)";
            $this->params[":$column1"] = $value1;
            $this->params[":$column2"] = $value2;
            return $this;
        }

        public function whereNull($field)
        {
            $this->query .= (strpos($this->query, 'WHERE') === false ? ' WHERE ' : ' AND ') . "$field IS NULL";
            return $this;
        }

        public function groupBy($column = null)
        {
            $this->query .= " GROUP BY $column";
            return $this;
        }
        
        public function orderBy($column, $direction = 'ASC')
        {
            $this->query .= " ORDER BY $column $direction";
            return $this;
        }

        public function orderByRandom()
        {
            $this->query .= " ORDER BY RAND()"; 
            return $this;
        }

        public function limit($limit, $limits = null)
        {
            $limitsPart = isset($limits) ? ', ' . (int)$limits : '';
            $this->query .= " LIMIT :limit" . $limitsPart;
            $this->params[":limit"] = (int)$limit;
            return $this;
        }
        
        public function get()
        {
            $stmt = $this->__db->prepare($this->query);
            $this->bindParameters($stmt);
            $stmt->execute();
            $this->clear();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function first()
        {
            $stmt = $this->__db->prepare($this->query);
            $this->bindParameters($stmt);
            $stmt->execute();
            $this->clear();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function row()
        {
            $stmt = $this->__db->prepare($this->query);
            $this->bindParameters($stmt);
            $stmt->execute();
            $this->clear();
            return $stmt->fetchColumn();
        }

        private function bindParameters($stmt)
        {
            foreach ($this->params as $key => $value) {
                if ($key === ':limit') {
                    $stmt->bindValue($key, $value, PDO::PARAM_INT); 
                } else {
                    $stmt->bindValue($key, $value);
                }
            }
        }

        public function insertGetId($data)
        {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            
            $stmt = $this->__db->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            try {
                $stmt->execute();

                $lastInsertId = $this->__db->lastInsertId();
                return ['Error' => '000', 'Message' => 'Sukses', 'Data' => $lastInsertId];
            } catch (PDOException $e) {
                return ['Error' => '999', 'Message' => $e->getMessage()];
            } finally {
                $this->reset();
            }
        }

        public function insert($data)
        {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

            return $this->executeQuery($query, $data);
        }

        public function insertSelect($datasql, $params = [])
        {
            try {
                if (empty($datasql)) {
                    return ['Error' => '999', 'Table is not set for insert operati'];
                } 
                $query_data = $this->__db->prepare($datasql)->execute($params);
                $this->reset();
                return ['Error' => '000']; 
            } catch (PDOException $e) {
                return ['Error' => '999', 'Message' => $e->getMessage()];
            }
        }

        public function update($data)
        {
            $setClause = implode(", ", array_map(fn($column) => "$column = :$column", array_keys($data)));
            $query = "UPDATE {$this->table} SET $setClause {$this->read}";
            return $this->executeQuery($query, $data);
        }

        public function whereid($field, $operator = '=', $value = null)
        {
            $this->read .= (strpos($this->read, 'WHERE') === false ? ' WHERE ' : ' AND ') . "$field $operator :$field";
            $this->params[":$field"] = $value;
            return $this;
        }

        public function delete($data)
        {
            try {
                $query = "DELETE FROM {$this->table} {$this->read}";
                $this->executeQuery($query, $data);
                return ['Error' => '000', 'Message' => 'Data berhasil dihapus.'];
            } catch ( PDOException $e ) {
                return ['Error' => '999', 'Message' => 'Error' . $e];
            }
        }

        private function prepareAndExecute($query)
        {
            try {
                $stmt = $this->__db->prepare($query); 
                foreach ($this->params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $stmt->execute();
                return ['Error' => '000']; 
            } catch (PDOException $e) {
                return ['Error' => '999', 'Message' => $e->getMessage()];
            } finally {
                $this->reset();
            }
        }

        private function executeQuery($query, $data = [])
        {
            try {
                $stmt = $this->__db->prepare($query);
                foreach ($data as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
                $stmt->execute();
                return ['Error' => '000'];
            } catch (PDOException $e) {
                return ['Error' => '999', 'Message' => $e->getMessage()];
            } finally {
                $this->reset();
            }
        }

        public function reset()
        {
            $this->query = '';
            $this->params = [];
            $this->read = '';
            $this->limit = null;
        }

        private function clear() {
            $this->query = "";
            $this->params = [];
        }
    }