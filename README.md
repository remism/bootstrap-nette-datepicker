bootstrap-nette-datepicker
==========================

A nette-bootstrap-datepicker based on 
  - https://github.com/lichtner/bootstrap-datepicker (original from Stefan Petre's http://www.eyecon.ro/bootstrap-datepicker/)
  - https://github.com/JanTvrdik/NetteExtras/tree/master/NetteExtras/Components/DatePicker

1) See https://github.com/lichtner/bootstrap-datepicker/blob/master/README.md

2) Attach necessary files (jQuery, Twitter Bootstrap and netteForms are required)

    <link href="{$basePath}/css/datepicker.css" rel="stylesheet" media="screen">
    <script src="{$basePath}/js/bootstrap-datepicker.js"></script>

2) Add extension method to all form

    \Nette\Forms\Container::extensionMethod(
      'addDatePicker', function (\Nette\Forms\Container $container, $name, $label = NULL) {
        return $container[$name] = new DatePicker('dd.mm.yyyy', $label);
    });


