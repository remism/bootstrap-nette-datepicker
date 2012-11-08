bootstrap-nette-datepicker
==========================

A nette-bootstrap-datepicker based on 
  - https://github.com/lichtner/bootstrap-datepicker (original from Stefan Petre's http://www.eyecon.ro/bootstrap-datepicker/)
  - https://github.com/JanTvrdik/NetteExtras/tree/master/NetteExtras/Components/DatePicker

1) See https://github.com/lichtner/bootstrap-datepicker/blob/master/README.md

2) Attach necessary files (jQuery, Twitter Bootstrap and netteForms are required)

    <link href="{$basePath}/css/datepicker.css" rel="stylesheet" media="screen">
    <script src="{$basePath}/js/bootstrap-datepicker.js"></script>
4) Init datepickers

		$(document).ready(function () {
			$('div.input-append.date').datepicker();
		});

3) Add extension method to all form

Use the same date format as in original js component

    \Nette\Forms\Container::extensionMethod(
      'addDatePicker', function (\Nette\Forms\Container $container, $name, $label = NULL) {
        return $container[$name] = new DatePicker('dd.mm.yyyy', $label);
    });

5) Usage

    $form->addDatePicker('date', "Date")
	  ->setClassName('date')//'date' defalt
	  ->setAutoclose(true)//false default
	  ->setTodayHighlight()//or setTodadyHighlight(true); false default
	  ->setWeekStart(1)//0 for Sunday, 6 for Saturday; 1 is default
	  ->setKeyboardNavigation()//or setKyeboardnavigation(true); true default
	  ->setTodayButton(DatePicker::TODAY_BUTTON_TRUE)//TODAY_BUTTON_FALSE |TODAY_BUTTON_TRUE | TODAY_BUTTON_LINKED; TODAY_BUTTON_FALSE default
	  ->setStartview(DatePicker::STARTVIEW_MONTH)//STARTVIEW_MONTH | STARTVIEW_YEAR | STARTVIEW_DECADE; STARTVIEW_MONTH default
	  ->setRequired()
	  ->addCondition(Nette\Forms\Form::FILLED)
	  ->addRule(
			DatePicker::DATE_RANGE,
			'Entered date is not within allowed range.',
			array(new DateTime('2012-10-02'),	new DateTime('2012-11-30')));

6) Control generates something like this

		<div class="input-append date" id="datepicker" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
    		<input type="text" value="12-02-2012">
    		<span class="add-on"><i class="icon-calendar"></i></span>
		</div>


