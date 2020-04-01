
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css" rel="stylesheet" />
    <meta name="description" content="Jesr est une plateforme pour la coordination des collectes de don, elle permet d’associer chaque association voulant participer dans la lutte contre le virus, à un intervenant de l’état le plus proche, que ce soit les UTSS (union tunisienne de la solidarité sociale) ou bien le CRRC. Elle permet entre autre de diriger les particuliers aux associations qui lui sont le plus proche.">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <script>window.Laravel = { csrfToken: '{{csrf_token() }}' }</script>
    <title>Jesr | جسر</title>


  </head>
  <body>
    <noscript>
      <strong>We're sorry but vue-white-dashboard doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div class="wrapper" id="app"></div>
    <!-- built files will be auto injected -->
  </body>
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script>
    var botmanWidget = {
        chatServer: 'https://nameless-atoll-27397.herokuapp.com/optibot',
        frameEndpoint: 'https://nameless-atoll-27397.herokuapp.com/chat',
        mainColor: '#48dbfb',
        sendWidgetOpenedEvent: true,
        headerTextColor: 'white',
        placeholderText: '...اكتب الرد',
        title: 'جسر بوت'
    };
</script>
<script id="botmanWidget" src="https://nameless-atoll-27397.herokuapp.com/js/widget.js"></script>
</html>
