<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="{{ asset('vite.svg') }}" />
    <title>Report</title>    
    <script type="module" defer="defer" src="{{ asset('index.js') }}"></script>    
    <link href="{{ asset('index.css') }}" rel="stylesheet" />
  </head>
  <body>
    <noscript>
      <strong>This apps needs JavaScript to run</strong>
    </noscript>
    <div id="app"></div>
  </body>
</html>
