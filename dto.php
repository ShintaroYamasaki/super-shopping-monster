<?php
class DTO {
  public $error_msg = "";

  private $pdo = null;
  private $db_name = null;

  public function __construct() {
    $this->pdo = null;
  }

  public function connect($db_name, $db_host, $db_port, $db_user, $db_pass) {
    if ($this->pdo != null) return true;

    $this->db_name = $db_name;
    try {
      $dsn = "mysql:dbname=${db_name};host=${db_host};port=${db_port}";
      // Connect
      $this->pdo = new PDO($dsn, $db_user, $db_pass);
    } catch (PDOException $e) {
      $this->error_msg = $e->getMessage();
      return false;
    }

    return true;
  }

  public function disconnect() {
    try {
      // Disconnect
      $this->pdo = null;
    } catch (PDOException $e) {
      $this->error_msg = $e->getMessage();
      return false;
    }

    return true;
  }

  public function execute_sql($sql, $params) {
    if ($this->pdo == null)
      throw new PDOException("Database is NOT connected.");

    try {
      $statement = $this->pdo->prepare($sql);
      if (count($params) >= 1) {
        foreach ($params as $key => &$value) {
          $statement->bindParam($key, $value);
        }
        unset($value);
      }

      $statement->execute();

      $rst = $statement->fetchAll();
    } catch (PDOException $e) {
      $this->error_msg = $e->getMessage();
      return null;
    }

    return $rst;
  }
}

class AccountsDTO extends DTO{
  const DB_NAME = "shopping";
  const DB_HOST = "127.0.0.1";
  const DB_PORT = "3306";
  const DB_USER = "root";
  const DB_PASS = "root";
  const TABLE_NAME = "accounts";

  public function __construct() {
    parent::__construct();
  }

  public function confirm_login ($account_name, $account_pass) {
    $is_connect = parent::connect(self::DB_NAME, self::DB_HOST, self::DB_PORT, self::DB_USER, self::DB_PASS);
    if (!$is_connect) return false;

    $sql = "SELECT name FROM ".self::TABLE_NAME." WHERE name = :name AND password = :password;";
    $params = array(
        ":name" => $account_name,
        ":password" => $account_pass
    );
    $rst = parent::execute_sql($sql, $params);

    parent::disconnect();
    if ($rst == null || count($rst) == 0)
      return false;

    return true;
  }
}

class ItemsDTO extends DTO {
  const DB_NAME = "shopping";
  const DB_HOST = "127.0.0.1";
  const DB_PORT = "3306";
  const DB_USER = "root";
  const DB_PASS = "root";
  const TABLE_NAME = "items";

  public function __construct() {
    parent::__construct();
  }

  public function select_items($keys) {
    $is_connect = parent::connect(self::DB_NAME, self::DB_HOST, self::DB_PORT, self::DB_USER, self::DB_PASS);
    if (!$is_connect) return null;


    $sql = "SELECT * FROM ".self::TABLE_NAME;
    $params = array();
    if (count($keys) >= 1) {
      $len = count($keys);
      $sql .= " WHERE ";
      $i = 1;
      foreach ($keys as &$key) {
        $sql .= "name LIKE ?";
        $params[$i] = "%".$key."%";

        if ($i != $len)
          $sql .= " AND ";

        $i += 1;
      }
      unset($key);
    }
    $sql .= ";";

    $rst = parent::execute_sql($sql, $params);

    parent::disconnect();
    if ($rst == null || count($rst) == 0)
      return array();

    return $rst;

  }

  public function select_items_w_ids($ids) {
    if (count($ids) == 0)
      return null;

    $is_connect = parent::connect(self::DB_NAME, self::DB_HOST, self::DB_PORT, self::DB_USER, self::DB_PASS);
    if (!$is_connect) return null;


    $sql = "SELECT * FROM ".self::TABLE_NAME;
    $params = array();
    if (count($ids) >= 1) {
      $len = count($ids);
      $sql .= " WHERE ";
      $i = 1;
      foreach ($ids as &$id) {
        $sql .= "id = ?";
        $params[$i] = $id;

        if ($i != $len)
          $sql .= " OR ";

        $i += 1;
      }
      unset($id);
    }
    $sql .= ";";

    $rst = parent::execute_sql($sql, $params);

    parent::disconnect();
    if ($rst == null || count($rst) == 0)
      return array();

    return $rst;
  }
}