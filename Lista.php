<?php// Lista - and not List - because List is a reserved keyword.class Lista extends DBHandler {  static function create($name='') {    $q = "INSERT INTO lists (name, created_at) VALUES (?,NOW())";    $sql_data = array($name);    $s = self::$db->prepare($q);    return $s->execute($sql_data);  }  static function read($id) {    if ($id > 0) {      $q = "SELECT * FROM lists WHERE id=?";      $s = self::$db->prepare($q);      if ( $s->execute(array($id)) ) {        return $s->fetchObject();      }    }    return false;  }  static function update($id, $name='') {    if ($id > 0) {      $q = "UPDATE `lists` SET `name`=?, `updated_at`=NOW() WHERE `id`=?";      $sql_data = array($name, $id);      $s = self::$db->prepare($q);      return $s->execute($sql_data);    }    return false;  }  static function delete($id) {    if ($id > 0) {      $q = "UPDATE lists SET is_deleted=1 WHERE id=?";      $s = self::$db->prepare($q);      return $s->execute(array($id));    }    return false;  }  static function all() {    $q = "SELECT * FROM lists WHERE is_deleted <= 0";    $s = self::$db->prepare($q);    if ($s->execute()) {      return $s->fetchAll(PDO::FETCH_OBJ);    }    return false;  }  static function all_with_users_count() {    $q = "SELECT l.*, COUNT(u.id) users_count FROM lists l    LEFT JOIN users u ON l.id = u.list_id    WHERE l.is_deleted <= 0    GROUP BY l.id    ORDER BY l.id";    $s = self::$db->prepare($q);    if ($s->execute()) {      return $s->fetchAll(PDO::FETCH_OBJ);    }    return false;  }  /* Returns an array without duplicates.  * @param $list a list of email addresses.  */  public static function remove_duplicates_from($list, $separator="\n") {    $array_with_dupes = explode($separator, $list);    $array_sanitized = array_unique($array_with_dupes);    return $array_sanitized;  }}