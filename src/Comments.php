<?php

class Comments {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }
  
  function showAll()
  {
    $sql = $this->conn->prepare(
      "SELECT *
      FROM comments
    ");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function show_comments_book($id)
  {
    $sql = $this->conn->prepare(
      "SELECT *
      FROM comments
      WHERE book_id = $id
    ");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function show_comments_user($id)
  {
    $sql = $this->conn->prepare(
      "SELECT *
      FROM comments
      WHERE user_id = $id
    ");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare("SELECT comments.id,
    user.name AS user,
    book.title
    FROM comments
    INNER JOIN user ON comments.user_id = user.id
    INNER JOIN book_version ON comments.book_version_id = book_version.id
    INNER JOIN book ON book_version.book_id = book.id
    WHERE comments.id = ?");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $user_id = $data['user_id'];
    $book_id = $data['book_id'];
    $comment = $data['comment'];
    $note = $data['note'];
    $sql = $this->conn->prepare("INSERT INTO comments (user_id, book_id, comment, note) VALUES (:user_id, :book_id, :comment, :note)");
    $sql->bindValue(':user_id', $user_id);
    $sql->bindValue(':book_id', $book_id);
    $sql->bindValue(':comment', $comment);
    $sql->bindValue(':note', $note);
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
