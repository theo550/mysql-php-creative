<?php

class Book {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }
  
  function showAll()
  {
    $sql = $this->conn->prepare(
      "SELECT book.id,
      title,
      description,
      tags.name AS genre,
      author.name AS author
      FROM book
      INNER JOIN author ON book.author_id = author.id
      INNER JOIN tags ON book.tags_id = tags.id"
    );
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare(
      "SELECT book.id,
      book.title,
      book.description,
      tags.name AS genre,
      author.name AS author
      FROM book
      INNER JOIN author ON book.author_id = author.id
      INNER JOIN tags ON book.tags_id = tags.id
      WHERE book.id = ?"
    );
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function get_book_stat($id)
  {
    $sql = $this->conn->prepare(
      "SELECT comments.book_id,
      AVG(comments.note) AS average
      FROM comments
      WHERE comments.book_id = ?
      GROUP BY book_id
    ");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $title = $data['title'];
    $description = $data['description'];
    $tags = $data['tags'];
    $author = $data['author'];
    $sql = $this->conn->prepare("INSERT INTO book (title, description, tags_id, author_id) VALUES (?, ?, ?, ?)");
    return $sql->execute([$title, $description, $tags, $author]);
  }

  function edit($id)
  {

  }

  function delete($id)
  {
    $sql = $this->conn->prepare("DELETE FROM book WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
  }

}
