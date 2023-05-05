<?php

include '../Bootstrap.php';
include 'Router.php';
include './utils/routes.php';

if (str_contains($_SERVER['REQUEST_URI'], '/?users')){
  createRoute('users', User::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?books')){
  createRoute('books', Book::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?authors')){
  createRoute('authors', Author::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?editions')){
  createRoute('editions', Edition::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?publishers')){
  createRoute('publishers', Publisher::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?tags')){
  createRoute('tags', Tags::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?bookversion')){
  createRoute('bookversion', BookVersion::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?library')){
  createRoute('library', Library::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?wishlist')){
  createRoute('wishlist', Wishlist::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?comments')){
  createRoute('comments', Comments::class);
} else if (str_contains($_SERVER['REQUEST_URI'], '/?author')){
  createRoute('author', Author::class);
} 
