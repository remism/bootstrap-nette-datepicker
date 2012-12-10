bootstrap-nette-datepicker
==========================

A nette-bootstrap-datepicker based on
  - https://github.com/lichtner/bootstrap-datepicker (original from Stefan Petre's http://www.eyecon.ro/bootstrap-datepicker/)
  - https://github.com/JanTvrdik/NetteExtras/tree/master/NetteExtras/Components/DatePicker

######1) See https://github.com/lichtner/bootstrap-datepicker/blob/master/README.md

######2) Attach necessary files (jQuery, Twitter Bootstrap and netteForms are required)

    <link href="{$basePath}/css/datepicker.css" rel="stylesheet" media="screen">
    <script src="{$basePath}/js/bootstrap-datepicker.js"></script>

You can attach language file.

		<script src="{$basePath}/js/bootstrap-datepicker.cs.js"></script>

Translantions can be downloaded from https://github.com/lichtner/bootstrap-datepicker/tree/master/js/locales or you can make you own.


######3) Init datepickers

		$(document).ready(function () {
			$('.bootstrapDatePicker').datepicker();
		});

You can set your own class by

		setClassName('myBetterClass');

Then you should init datepicker using

		$(document).ready(function () {
			$('.myBetterClass').datepicker();
		});

When input has no button (see below) then bootstrapDatePicker class is added directly to input element. When button is on calendar input is wrrapped by div and bootstrapDatePicker class is added to this div.
######4) Add extension method to all form (date format and languge are set globally)

Use the same date format as in original js component (see https://github.com/lichtner/bootstrap-datepicker/blob/master/README.md#format)

    \Nette\Forms\Container::extensionMethod(
      'addDatePicker', function (\Nette\Forms\Container $container, $name, $label = NULL) {
        return $container[$name] = new BeWeb\Components\Nette\BootstrapDatePicker('dd.mm.yyyy', 'cs', $label);
    });

or simply

		BeWeb\Components\Nette\BootstrapDatePicker::register('dd.mm.yyyy', 'cs', 'addDatePicker');

or for default values ('yyyy-mm-dd', 'en', 'addDatePicker')

		BeWeb\Components\Nette\BootstrapDatePicker::register();

######5) Usage

		$form->addDatePicker('date', "Date")
		->setClassName('myBetterClass')//'bootstrapDatePicker' defalt
		->setAutoclose(true)//true default
		->setTodayHighlight()//or setTodadyHighlight(true); false default
		->setWeekStart(1)//0 for Sunday, 6 for Saturday; 1 is default
		->setKeyboardNavigation()//or setKyeboardnavigation(true); true default
		->setTodayButton(\BeWeb\Components\Nette\BootstrapDatePicker::TODAY_BUTTON_TRUE)//TODAY_BUTTON_FALSE | TODAY_BUTTON_TRUE | TODAY_BUTTON_LINKED; TODAY_BUTTON_FALSE default
		->setStartview(\BeWeb\Components\Nette\BootstrapDatePicker::STARTVIEW_MONTH)//STARTVIEW_MONTH | STARTVIEW_YEAR | STARTVIEW_DECADE; STARTVIEW_MONTH default
		->setRequired()
		->setInputButtonStyle(\BeWeb\Components\Nette\BootstrapDatePicker::BUTTON_STYLE_ICON_RIGHT)//BUTTON_STYLE_ICON_LEFT | BUTTON_STYLE_ICON_RIGHT | BUTTON_STYLE_ICON_NONE; BUTTON_STYLE_ICON_RIGHT default
		->addCondition(Nette\Forms\Form::FILLED)
		->addRule(
			\BeWeb\Components\Nette\BootstrapDatePicker::DATE_RANGE,
			'Entered date is not within allowed range.',
			array(new DateTime('2012-10-02'),	null));

Alternatively you can use

	  ->addRule(
			BeWeb\Components\Nette\BootstrapDatePicker::DATE_RANGE,
			'Entered date is not within allowed range.',
			array(new DateTime('2012-10-02'), null));

to set only calendar minimum (or only maximum).
Datepicker will show only applicable dates. Value is checked on submit by javascript and then by php on server side.

Use BeWeb\Components\Nette\BootstrapDatePicker::DATE_RANGE to apply date range. \Nette\Forms\Form::RANGE will not work

######6) Control generates something like this

		<div class="input-append date myBetterClass"
			data-date-autoclose="true"
			data-date-start-view="0"
			data-date-today-btn="1"
			data-date-today-highlight="1"
			data-date-weekstart="1"
			data-date-keyboard-navigation="1"
			data-date-format="dd.mm.yyyy"
			data-date-language="cs"
			data-date-startdate="02.10.2012">
				<input type="text"
					class="text" name="date"
					id="frmform-date"
					required="required"
					data-nette-rules="{op:':filled',msg:'Please complete mandatory field.'},{op:':filled',rules:[{op:':dateRange',msg:'Entered date is not within allowed range.',arg:[{date:'2012-10-02 00:00:00',timezone_type:3,timezone:&quot;Europe\/Prague&quot;},null]}],control:'date'}">
				<span class="add-on"><i class="icon-calendar"></i></span>
		</div>
