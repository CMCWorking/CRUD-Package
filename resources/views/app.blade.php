<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token"
          value="{{ csrf_token() }}">
    <title>Vue CRUD</title>

    <link rel="stylesheet"
          href="{{ mix('css/app.css') }}"
          type="text/css"
          rel="stylesheet">
</head>

<body>
    <div id="app"></div>

    <modal v-if="showModal"
           @close="showModal = false">
    </modal>

    <script src="{{ mix('js/app.js') }}"
            type="text/javascript"></script>
</body>

</html>
