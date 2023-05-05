<?php

class Wishlist {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }
  
  function showAll()
  {
    $sql = $this->conn->prepare(
      "SELECT wishlist.id,
      user.name AS user,
      book.title
      FROM wishlist
      INNER JOIN user ON wishlist.user_id = user.id
      INNER JOIN book_version ON wishlist.book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
    ");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare("SELECT wishlist.id,
    user.name AS user,
    book.title
    FROM wishlist
    INNER JOIN user ON wishlist.user_id = user.id
    INNER JOIN book_version ON wishlist.book_version_id = book_version.id
    INNER JOIN book ON book_version.book_id = book.id
    WHERE wishlist.id = ?");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $user_id = $data['user_id'];
    $book_version_id = $data['book_version_id'];
    $sql = $this->conn->prepare("INSERT INTO wishlist (user_id, book_version_id) VALUES (:user_id, :book_version_id)");
    $sql->bindValue(':user_id', $user_id);
    $sql->bindValue(':book_version_id', $book_version_id);
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

}
