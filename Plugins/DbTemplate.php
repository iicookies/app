<?php



/**
 * 一个数据库操作工具类
 *
 * @author zhjiun@gmail.com
 */
class DbTemplate {

    /**
     * 返回多行记录
     * @param  $sql
     * @param  $parameters
     * @return  记录数据
     */
    public function queryRows($sql, $parameters = null) {
        return $this->exeQuery($sql, $parameters);
    }

    /**
     * 返回为单条记录
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryRow($sql, $parameters = null) {
        $rs = $this->exeQuery($sql, $parameters);
        if (count($rs) > 0) {
            return $rs[0];
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回整数
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryForInt($sql, $parameters = null) {
        $rs = $this->exeQuery($sql, $parameters);
        if (count($rs) > 0) {
            return intval($rs[0][0]);
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回浮点数(float)
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryForFloat($sql, $parameters = null) {
        $rs = $this->exeQuery($sql, $parameters);
        if (count($rs) > 0) {
            return floatval($rs[0][0]);
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回浮点数(double)
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryForDouble($sql, $parameters = null) {
        $rs = $this->exeQuery($sql, $parameters);
        if (count($rs) > 0) {
            return doubleval($rs[0][0]);
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回对象，实际类型有数据库决定
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryForObject($sql, $parameters = null) {
        $rs = $this->exeQuery($sql, $parameters);
        if (count($rs) > 0) {
            return $rs[0][0];
        } else {
            return null;
        }
    }

    /**
     * 执行一条更新语句.insert / upadate / delete
     * @param  $sql
     * @param  $parameters
     * @return  影响行数
     */
    public function update($sql, $parameters = null) {
        return $this->exeUpdate($sql, $parameters);
    }

    public function getConnection($transaction = false) {
        #$conn = new PDO(DbConfig::getDsn(), DbConfig::getUsername(), DbConfig::getPassword());
        #$conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
        #$conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER, PDO::ERRMODE_EXCEPTION);
        $conn = DpPool::getConn($transaction);
        return $conn;
    }

    private function exeQuery($sql, $parameters = null) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($parameters);
        $rs = $stmt->fetchAll();
        $stmt = null;
        $conn = null;
        return $rs;
    }

    private function exeUpdate($sql, $parameters = null) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($parameters);
        $affectedRows = $stmt->rowCount();
        $stmt = null;
        $conn = null;
        return $affectedRows;
    }

}



