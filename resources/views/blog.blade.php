<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AI Blog Editor</title>
  @vite('resources/js/app.js')
</head>
<body class="m-0 p-0 h-screen w-screen overflow-hidden">
    <div id="blog" class="h-full w-full"></div>
</body>
</html>
