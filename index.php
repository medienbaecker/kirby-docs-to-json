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

              if(!Str::startsWith($page->title()->value(), '$')) continue;

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
                "prefix" => '->' . $page->name() . '()',
                "body" => '->' . $page->name() . '(' . implode(", ", $body) . ')',
                "description" => $page->intro()->escape()->value(),
                "scope" => "php"
              );
              
            }
          }

          // Field methods
          addToArray(page("docs/reference/templates/field-methods")->children()->listed(), $json);

          // Kirby methods
          addToArray(page("docs/reference/objects/cms/app")->children()->listed(), $json);

          // Site methods
          addToArray(page("docs/reference/objects/cms/site")->children()->listed(), $json);

          // Page methods
          addToArray(page("docs/reference/objects/cms/page")->children()->listed(), $json);

          // Pages methods
          addToArray(page("docs/reference/objects/cms/pages")->children()->listed(), $json);

          // File methods
          addToArray(page("docs/reference/objects/cms/file")->children()->listed(), $json);

          // Files methods
          addToArray(page("docs/reference/objects/cms/files")->children()->listed(), $json);

          // User methods
          addToArray(page("docs/reference/objects/cms/user")->children()->listed(), $json);

          // Users methods
          addToArray(page("docs/reference/objects/cms/users")->children()->listed(), $json);

          // Blocks methods
          addToArray(page("docs/reference/objects/cms/blocks")->children()->listed(), $json);

          // Blocks methods
          addToArray(page("docs/reference/objects/cms/block")->children()->listed(), $json);

          // Layouts methods
          addToArray(page("docs/reference/objects/cms/layouts")->children()->listed(), $json);

          // Layout methods
          addToArray(page("docs/reference/objects/cms/layout")->children()->listed(), $json);

          // Language methods
          addToArray(page("docs/reference/objects/cms/language")->children()->listed(), $json);

          // Languages methods
          addToArray(page("docs/reference/objects/cms/languages")->children()->listed(), $json);

          // Pagination methods
          addToArray(page("docs/reference/objects/cms/pagination")->children()->listed(), $json);

          // Request methods
          addToArray(page("docs/reference/objects/http/request")->children()->listed(), $json);

          // Session methods
          addToArray(page("docs/reference/objects/session/session-data")->children()->listed(), $json);

          return $json;
        }
      }
    ]
  ]
]);