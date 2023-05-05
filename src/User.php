<?php

class User {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }
  
  function showAll()
  {
    $sql = $this->conn->prepare("SELECT * FROM user");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare("SELECT * FROM user WHERE id = ?");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $name = $data['name'];
    $sql = $this->conn->prepare("INSERT INTO user (name) VALUES (:name)");
    $sql->bindValue(':name', $name);
    return $sql->execute();
  }

  function edit($id)
  {

  }

  function delete($id)
  {
    $sql = $this->conn->prepare("DELETE FROM user WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
  }

  // nb of books by reading state by user
  function stat_by_user($id)
  {
    $sql = $this->conn->prepare(
      "SELECT library.reading_state,
      COUNT(*) AS total
      FROM library
      LEFT JOIN user ON library.user_id = user.id
      WHERE user.id = ?
      GROUP BY library.reading_state
    ");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

}
