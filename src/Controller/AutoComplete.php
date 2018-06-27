<?php

namespace Drupal\fossee_institute_profiles\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;


class AutoComplete extends ControllerBase {
  public function suggestion($str = '') {
    $response = new Response();
    $connection = \Drupal::database();
      $query = $connection->query('SELECT name FROM fossee_new.clg_names WHERE name LIKE :args LIMIT 10;',array(
        ':args'=>'%'.$str.'%'
    ));
    $rows = $query->fetchAll();
    foreach ($rows as $row) {
        $matches[] = $row->name;    // save the query to matches
    }
    $response->setContent(json_encode($matches));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }
}