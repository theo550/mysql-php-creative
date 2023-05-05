<?php

class Library {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }
  
  function showAll()
  {
    $sql = $this->conn->prepare(
      "SELECT library.id,
      book.title,
      reading_state,
      user.name AS user
      FROM library
      INNER JOIN user ON user_id = user.id
      INNER JOIN book_version ON book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
      ");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare(
      "SELECT library.id,
      book.title,
      reading_state,
      user.name AS user
      FROM library
      INNER JOIN user ON user_id = user.id
      INNER JOIN book_version ON book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
      WHERE library.id = ?
      "
    );
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find_library_by_user($user_id)
  {
    $sql = $this->conn->prepare(
      "SELECT library.id,
      user_id,
      user.name AS userName,
      reading_state,
      book.title,
      author.name AS author
      FROM library
      INNER JOIN user ON user_id = user.id
      INNER JOIN book_version ON book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      WHERE user_id = ?"
    );
    $sql->execute([$user_id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $book_version_id = $data['book_version_id'];
    $reading_state = $data['reading_state'];
    $user_id = $data['user_id'];
    $sql = $this->conn->prepare("INSERT INTO library (book_version_id, reading_state, user_id) VALUES (:book_version_id, :reading_state, :user_id)");
    $sql->bindValue(':book_version_id', $book_version_id);
    $sql->bindValue(':reading_state', $reading_state);
    $sql->bindValue(':user_id', $user_id);
    return $sql->execute();
  }

  function edit($id)
  {

  }

  function delete($id)
  {
    $sql = $this->conn->prepare("DELETE FROM library WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
  }

  function get_books_by_author($author_id, $user_id)
  {
    $sql = $this->conn->prepare(
      "SELECT library.user_id,
      author.id AS author_id,
      book.title,
      author.name AS author
      FROM library
      INNER JOIN book_version ON library.book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      WHERE author.id = ?
      AND library.user_id = ?
    ");
    $sql->execute([$author_id, $user_id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }
  
  function get_books_by_title($title, $user_id)
  {
    $sql = $this->conn->prepare(
      "SELECT book.title,
      author.name AS author,
      book.description
      FROM library
      INNER JOIN book_version ON library.book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      WHERE book.title = ?
      AND library.user_id = ?
    ");
    $sql->execute([$title, $user_id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }
  
  function get_books_by_editor($publisher, $user_id)
  {
    $sql = $this->conn->prepare(
      "SELECT book.title,
      author.name AS author,
      book.description,
      publisher.name
      FROM library
      INNER JOIN book_version ON library.book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      INNER JOIN publisher ON book_version.publisher_id = publisher.id
      WHERE book_version.publisher_id = ?
      AND library.user_id = ?
    ");
    $sql->execute([$publisher, $user_id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }
  
  function get_books_by_genre($genre, $user_id)
  {
    $sql = $this->conn->prepare(
      "SELECT book.title,
      author.name AS author,
      book.description,
      publisher.name AS publisher,
      tags.name AS gender
      FROM library
      INNER JOIN book_version ON library.book_version_id = book_version.id
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      INNER JOIN publisher ON book_version.publisher_id = publisher.id
      INNER JOIN tags ON book.tags_id = tags.id
      WHERE book.tags_id = ?
      AND library.user_id = ?
    ");
    $sql->execute([$genre, $user_id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

}
