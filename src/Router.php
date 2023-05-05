<?php

class Router {

  function get($path, $class)
  {
    if(isset($_GET[$path]) && $_SERVER['REQUEST_METHOD'] === 'GET'){
      $cl = new $class();
      if(isset($_GET['id']) && !isset($_GET['stat'])){
        echo $cl->find($_GET['id']);
      } else if (isset($_GET['library'])) {
        if (isset($_GET['title_lib'])) {
          echo $cl->get_books_by_title($_GET['title_lib'], $_GET['user_lib']);
        } else if (isset($_GET['editor_lib'])) {
          echo $cl->get_books_by_editor($_GET['editor_lib'], $_GET['user_lib']);
        } else if (isset($_GET['genre_lib'])) {
          echo $cl->get_books_by_genre($_GET['genre_lib'], $_GET['user_lib']);
        }
      } else if(isset($_GET['user'])){
        echo $cl->find_library_by_user($_GET['user']);
      } else if(isset($_GET['bookId'])){
        echo $cl->show_comments_book($_GET['bookId']);
      } else if(isset($_GET['commentUser'])){
        echo $cl->show_comments_user($_GET['commentUser']);
      } else if(isset($_GET['author']) && isset($_GET['books']) && isset($_GET['stat'])){
        echo $cl->author_book_stats($_GET['author']);
      } else if (isset($_GET['author'])){
        if (isset($_GET['stat'])) {
          echo $cl->get_author_books_number($_GET['id']);
        } else if (isset($_GET['bookversion'])) {
          echo $cl->get_book_version_by_author($_GET['author']);
        } else if (isset($_GET['library']) && isset($_GET['author_lib'])) {
          echo $cl->get_books_by_author($_GET['author'], $_GET['user_lib']);
        }
      } else if (isset($_GET['publisher'])){
        echo $cl->get_book_version_by_publisher($_GET['publisher']);
      } else if (isset($_GET['title'])){
        echo $cl->get_book_version_by_title($_GET['title']);
      } else if (isset($_GET['books']) && isset($_GET['stat'])){
        echo $cl->get_book_stat($_GET['id']);
      } else if (isset($_GET['users']) && isset($_GET['stat'])){
        echo $cl->stat_by_user($_GET['id']);
      } else if (isset($_GET['genre'])){
        echo $cl->get_book_version_by_tags($_GET['genre']);
      } else if (isset($_GET['edition'])){
        echo $cl->get_book_version_by_edition($_GET['edition']);
      } else {
        echo $cl->showAll();
      }
    }
  }

  function post($path, $class)
  {
    if (isset($_GET[$path]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
      $cl = new $class();

      if(file_get_contents("php://input")){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
      }

      echo $cl->create($data);

    }
  }

  function delete($path, $class)
  {
    if (isset($_GET[$path]) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $cl = new $class();
  
      $cl->delete($_GET['id']);
    }
  }
}
