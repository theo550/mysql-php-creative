<?php

class Edition {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }

  function showAll()
  {
    $sql = $this->conn->prepare("SELECT * FROM edition");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare("SELECT * FROM edition WHERE id = ?");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $name = $data['name'];
    $sql = $this->conn->prepare("INSERT INTO edition (name) VALUES (:name)");
    $sql->bindValue(':name', $name);
    return $sql->execute();
  }

  function edit($id)
  {

  }

  function delete($id)
  {
    $sql = $this->conn->prepare("DELETE FROM edition WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
  }
}