<?php

class BookVersion {
  protected $conn;

  function __construct()
  {
    $this->conn = Connexion::get();
  }
  
  function showAll()
  {
    $sql = $this->conn->prepare(
      "SELECT book_version.id,
      book.title,
      tags.name,
      publisher.name,
      edition.name,
      author.name AS author
      FROM book_version
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN tags ON book.tags_id = tags.id
      INNER JOIN publisher ON book_version.publisher_id = publisher.id
      INNER JOIN edition ON book_version.edition_id = edition.id
      INNER JOIN author ON book.author_id = author.id
    ");
    $sql->execute();
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function find($id)
  {
    $sql = $this->conn->prepare("SELECT book_version.id,
    book.title,
    tags.name,
    publisher.name,
    edition.name
    FROM book_version
    INNER JOIN book ON book_version.book_id = book.id
    INNER JOIN tags ON book.tags_id = tags.id
    INNER JOIN publisher ON book_version.publisher_id = publisher.id
    INNER JOIN edition ON book_version.edition_id = edition.id
    WHERE book_version.id = ?");
    $sql->execute([$id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function get_book_version_by_author($author_id){
    $sql = $this->conn->prepare(
      "SELECT book.title,
      author.name AS auhtor,
      publisher.name AS publisher,
      edition.name AS edition
      FROM book_version
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      INNER JOIN publisher ON book_version.publisher_id = publisher.id
      INNER JOIN edition ON book_version.edition_id = edition.id
      WHERE author.id = ?
    ");
    $sql->execute([$author_id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function get_book_version_by_tags($tag){
    $sql = $this->conn->prepare(
      "SELECT book.title,
      tags.name AS genre
      FROM book_version
      INNER JOIN book ON book_version.book_id = book.id
      LEFT JOIN tags ON book.tags_id = tags.id
      WHERE book.tags_id = ?
    ");
    $sql->execute([$tag]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }
 
  function get_book_version_by_edition($edition){
    $sql = $this->conn->prepare(
      "SELECT book.title,
      author.name AS author,
      edition.name AS edition
      FROM edition
      LEFT JOIN book_version ON edition.id = book_version.edition_id
      LEFT JOIN book ON book_version.book_id = book.id
      LEFT JOIN author ON book.author_id = author.id
      WHERE edition.id = ?
    ");
    $sql->execute([$edition]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function get_book_version_by_title($title){
    $sql = $this->conn->prepare(
      "SELECT book.title,
      author.name AS auhtor,
      publisher.name AS publisher
      FROM book_version
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      INNER JOIN publisher ON book_version.publisher_id = publisher.id
      WHERE book.title = ?
    ");
    $sql->execute([$title]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function get_book_version_by_publisher($publisher_id){
    $sql = $this->conn->prepare(
      "SELECT book.title,
      author.name AS auhtor,
      publisher.name AS publisher
      FROM book_version
      INNER JOIN book ON book_version.book_id = book.id
      INNER JOIN author ON book.author_id = author.id
      INNER JOIN publisher ON book_version.publisher_id = publisher.id
      WHERE publisher.id = ?
    ");
    $sql->execute([$publisher_id]);
    return json_encode($sql->fetchAll(), JSON_UNESCAPED_UNICODE);
  }

  function create($data)
  {
    $book_id = $data['book_id'];
    $book_tags_id = $data['book_tags_id'];
    $publisher_id = $data['publisher_id'];
    $edition_id = $data['edition_id'];
    $sql = $this->conn->prepare("INSERT INTO book_version (book_id, book_tags_id, publisher_id, edition_id) VALUES (?, ?, ?, ?)");
    return $sql->execute([$book_id, $book_tags_id, $publisher_id, $edition_id]);
  }

  function edit($id)
  {

  }

  function delete($id)
  {
    $sql = $this->conn->prepare("DELETE FROM book_version WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
  }

}
