<?php

Kirby::plugin('medienbaecker/snippet-generator', [
  'routes' => [
    [
      'pattern' => 'docs/snippets.json',
      'action'  => function () {
        if($reference = page("docs/reference")) {

          $json = array();

          function getArray($pages) {
            $array = array();
            foreach($pages as $page) {

              $parameters = array_column($page->parameters(), 'export');
              $body = array();
              $c = 0;
              foreach($parameters as $parameter) {
                if(preg_match('/\s/',$parameter)) {
                  $parameter = explode(" ", $parameter)[1];
                }
                $c++;
                $body[] = '${' . $c . ':\\' . $parameter . '}';
              }

              $array[$page->title()->value()] = array(
                "prefix" => '->' . $page->methodName() . '()',
                "body" => '->' . $page->methodName() . '(' . implode($body, ", ") . ')',
                "description" => $page->excerpt()->escape()->value(),
                "scope" => "php"
              );
              
            }
            return $array;
          }

          // Field methods
          $json[] = getArray(page("docs/reference/templates/field-methods")->children()->visible());

          // File methods
          $json[] = getArray(page("docs/reference/objects/file")->children()->visible());

          // Files methods
          $json[] = getArray(page("docs/reference/objects/files")->children()->visible());

          // Kirby methods
          $json[] = getArray(page("docs/reference/objects/kirby")->children()->visible());

          // Language methods
          $json[] = getArray(page("docs/reference/objects/language")->children()->visible());

          // Languages methods
          $json[] = getArray(page("docs/reference/objects/languages")->children()->visible());

          // Page methods
          $json[] = getArray(page("docs/reference/objects/page")->children()->visible());

          // Pages methods
          $json[] = getArray(page("docs/reference/objects/pages")->children()->visible());

          // Pagination methods
          $json[] = getArray(page("docs/reference/objects/pagination")->children()->visible());

          // Request methods
          $json[] = getArray(page("docs/reference/objects/request")->children()->visible());

          // Session methods
          $json[] = getArray(page("docs/reference/objects/session")->children()->visible());

          // Site methods
          $json[] = getArray(page("docs/reference/objects/site")->children()->visible());

          // User methods
          $json[] = getArray(page("docs/reference/objects/user")->children()->visible());

          // Users methods
          $json[] = getArray(page("docs/reference/objects/users")->children()->visible());

          return $json;
        }
      }
    ]
  ]
]);