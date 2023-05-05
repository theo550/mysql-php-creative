<?php

function createRoute($uri, $class){
  $router = new Router();
  $router->get($uri, $class);
  $router->post($uri, $class);
  $router->delete($uri, $class);
}