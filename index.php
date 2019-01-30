<?php

Kirby::plugin('medienbaecker/snippet-generator', [
  'routes' => [
    [
      'pattern' => 'docs/snippets.json',
      'action'  => function () {
        if($reference = page("docs/reference")) {

          $json = array();

          function addToArray($pages, &$json) {
            $array = array();
            foreach($pages as $page) {
              $parameters = array_column($page->parameters(), 'export');
              $body = array();
              $c = 0;

              foreach($parameters as $parameter) {
                if(strpos($parameter, '$') !== false) {
                  $parameter = strstr($parameter, '$');
                }
                $c++;
                $body[] = '${' . $c . ':\\' . $parameter . '}';
              }

              $json[$page->title()->value()] = array(
                "prefix" => '->' . $page->methodName() . '()',
                "body" => '->' . $page->methodName() . '(' . implode($body, ", ") . ')',
                "description" => $page->excerpt()->escape()->value(),
                "scope" => "php"
              );
              
            }
          }

          // Field methods
          addToArray(page("docs/reference/templates/field-methods")->children()->visible(), $json);

          // File methods
          addToArray(page("docs/reference/objects/file")->children()->visible(), $json);

          // Files methods
          addToArray(page("docs/reference/objects/files")->children()->visible(), $json);

          // Kirby methods
          addToArray(page("docs/reference/objects/kirby")->children()->visible(), $json);

          // Language methods
          addToArray(page("docs/reference/objects/language")->children()->visible(), $json);

          // Languages methods
          addToArray(page("docs/reference/objects/languages")->children()->visible(), $json);

          // Page methods
          addToArray(page("docs/reference/objects/page")->children()->visible(), $json);

          // Pages methods
          addToArray(page("docs/reference/objects/pages")->children()->visible(), $json);

          // Pagination methods
          addToArray(page("docs/reference/objects/pagination")->children()->visible(), $json);

          // Request methods
          addToArray(page("docs/reference/objects/request")->children()->visible(), $json);

          // Session methods
          addToArray(page("docs/reference/objects/session")->children()->visible(), $json);

          // Site methods
          addToArray(page("docs/reference/objects/site")->children()->visible(), $json);

          // User methods
          addToArray(page("docs/reference/objects/user")->children()->visible(), $json);

          // Users methods
          addToArray(page("docs/reference/objects/users")->children()->visible(), $json);

          return $json;
        }
      }
    ]
  ]
]);