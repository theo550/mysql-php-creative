<?php

class Author {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }

  function showAll()
  {
    $sql = $this->conn->prepare("SELECT * FROM author");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare("SELECT * FROM author WHERE id = ?");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function get_author_books_number($id)
  {
    $sql = $this->conn->prepare(
      "SELECT COUNT(*) AS nb_books,
      author.name AS author
      FROM book
      INNER JOIN author ON book.author_id = author.id
      WHERE author_id = ?
    ");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $name = $data['name'];
    $sql = $this->conn->prepare("INSERT INTO author (name) VALUES (:name)");
    $sql->bindValue(':name', $name);
    return $sql->execute();
  }

  function edit($id)
  {

  }

  function delete($id)
  {
    $sql = $this->conn->prepare("DELETE FROM author WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
  }

  function author_book_stats($id)
  {
    $sql = $this->conn->prepare(
      "SELECT author.name AS author,
      COUNT(wishlist.id) wishlisted,
      COUNT(library.id) in_library,
      ROUND(AVG(comments.note)) AS average
      FROM book
      INNER JOIN author ON book.author_id = author.id
      LEFT JOIN comments ON book.id = comments.book_id
      INNER JOIN book_version ON book.id = book_version.book_id
      LEFT JOIN library ON book_version.id = library.book_version_id
      LEFT JOIN wishlist ON book_version.id = wishlist.book_version_id
      WHERE book.author_id = ?
    ");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }
}
