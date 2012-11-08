<?php

class DatePicker extends Nette\Forms\Controls\BaseControl {
	/** Range validator */
	const DATE_RANGE = ':dateRange';
	/** Defaut date format */
	const W3C_DATE_FORMAT = 'yyyy-mm-dd';

	/** Calendar viemode with month overview. */
	const STARTVIEW_MONTH = 0;
	/** Calendar viemode with year overview. */
	const STARTVIEW_YEAR = 1;
	/** Calendar viemode with dacade overview. */
	const STARTVIEW_DECADE = 2;
	/** Calendar without today button. */
	const TODAY_BUTTON_FALSE = false;
	/** Calendar with simple today button which scrolls calendar to now. */
	const TODAY_BUTTON_TRUE = true;
	/** Calendar with today button which scrolls calendar to now and set value. */
	const TODAY_BUTTON_LINKED = 'linked';

	/** @var     string            class name	Class to detect inputs in DOM */
	private $className = 'date';

	/** @var     string						date format	Date format - d, m, M, y */
	private $format = self::W3C_DATE_FORMAT;

	/** @var     bool							autoclose flag	If true calendar will be closed on click */
	private $autoclose = false;

	/** @var     bool							If true today column will be highlighted */
	private $todayHighlight = false;

	/** @var     number						Definition of first day of week. 0 for Sunday, 6 for Saturday */
	private $weekStart = self::STARTVIEW_MONTH;

	/** @var     bool						Switch keyboard navigation on/off */
	private $keyboardNavigation = true;

	/** @var     number					Today button mode */
	private $todayButton = self::TODAY_BUTTON_FALSE;

	/** @var     number					Startview mode */
	private $startview = 1;


	/** @var     string            value entered by user (unfiltered) */
	protected $rawValue;

	/**
	 * Class constructor.
	 *
	 * @param    string            date format
	 * @param    string            label
	 */
	public function __construct($format = self::W3C_DATE_FORMAT, $label = NULL)
	{
		parent::__construct($label);
		$this->control->type = 'text';
		$this->format = $format;
	}

	/**
	 * Switch keyboard navigation on / off
	 *
	 * @param    number
	 * @return   self
	 */
	public function setKeyboardNavigation($state = true)
	{
		$this->keyboardNavigation = $state;
		return $this;
	}

	/**
	 * Returns keyboard state
	 *
	 * @return   number
	 */
	public function getKeyboardNavigation()
	{
		return $this->keyboardNavigation;
	}

	/**
	 * Sets first day of week.
	 *
	 * @param    number 0 for sunday, 6 for staurday
	 * @return   self
	 */
	public function setWeekStart($weekStart)
	{
		$this->weekStart = $weekStart;
		return $this;
	}

	/**
	 * Returns first day of week for this calendar
	 *
	 * @return   number
	 */
	public function getWeekStart()
	{
		return $this->weekStart;
	}

	/**
	 * Sets startview mode
	 *
	 * @param    number 	STARTVIEW_MONTH | STARTVIEW_YEAR | STARTVIEW_DECADE
	 * @return   self
	 */
	public function setStartview($startview)
	{
		$this->startview = $startview;
		return $this;
	}

	/**
	 * Returns startview mode
	 *
	 * @return   number
	 */
	public function getStartview()
	{
		return $this->autoclose;
	}

	/**
	 * Returns today button mode.
	 *
	 * @return   number
	 */
	public function todayButton()
	{
		return $this->todayButton;
	}

	/**
	 * Sets today button mode
	 *
	 * @param    number	TODAY_BUTTON_FALSE |TODAY_BUTTON_TRUE | TODAY_BUTTON_LINKED
	 * @return   self
	 */
	public function setTodayButton($todayButton = self::TODAY_BUTTON_LINKED)
	{
		$this->todayButton = $todayButton;
		return $this;
	}

	/**
	 * Returns true if calendar should highlight today column.
	 *
	 * @return   bool
	 */
	public function todayHighlight()
	{
		return $this->todayHighlight;
	}

	/**
	 * Turns on today column highlighting
	 *
	 * @param    bool
	 * @return   self
	 */
	public function setTodayHighlight($highlight = true)
	{
		$this->todayHighlight = $highlight;
		return $this;
	}

	/**
	 * Returns true if calendar should be closed when date is selected.
	 *
	 * @return   bool
	 */
	public function autoclosed()
	{
		return $this->autoclose;
	}

	/**
	 * Sets class autoclose flag. When autoclose flag is set to true calendar will be closed when date is selected.
	 *
	 * @param    bool
	 * @return   self
	 */
	public function setAutoclose($autoclose = true)
	{
		$this->autoclose = $autoclose;
		return $this;
	}

	/**
	 * Returns class name.
	 *
	 * @return   string
	 */
	public function getClassName()
	{
		return $this->className;
	}

	/**
	 * Sets class name for input element.
	 *
	 * @param    string
	 * @return   self
	 */
	public function setClassName($className)
	{
		$this->className = $className;
		return $this;
	}

	/**
	 * Generates control's HTML element.
	 *
	 * @return   Nette\Web\Html
	 */
	public function getControl()
	{
		$control = parent::getControl();

		$div = Nette\Utils\Html::el('div');
		$div->addClass('input-append');
		$div->addClass($this->className);
		$div->data['date-autoclose'] = $this->autoclose?'true':'false';
		$div->data['date-start-view'] = $this->startview;
		$div->data['date-today-btn'] = $this->todayButton;
		$div->data['date-today-highlight'] = $this->todayHighlight;
		$div->data['date-weekstart'] = $this->weekStart;
		$div->data['date-keyboard-navigation'] = $this->keyboardNavigation;
		$div->data['date-format'] = $this->format;
		$div->data['date-language'] = 'en';

		list($min, $max) = $this->extractRangeRule($this->getRules());
		if ($min !== NULL) $div->data['date-startdate'] = $min->format($this->toPhpFormat ($this->format));
		if ($max !== NULL) $div->data['date-enddate'] = $max->format($this->toPhpFormat ($this->format));
		if ($this->value) $div->data['date-date'] = $control->value = $this->value->format($this->toPhpFormat ($this->format));
		$div->add($control);
		$div->add('<span class="add-on"><i class="icon-calendar"></i></span>');
		return $div;
	}
	/**
	 * Sets DatePicker value.
	 *
	 * @author   Jan Tvrdík
	 * @param    DateTime|int|string
	 * @return   self
	 */
	public function setValue($value)
	{
		if ($value instanceof DateTime) {

		} elseif (is_int($value)) { // timestamp

		} elseif (empty($value)) {
			$rawValue = $value;
			$value = NULL;

		} elseif (is_string($value)) {
			$rawValue = $value;
			$value = DateTime::createFromFormat($this->toPhpFormat($this->format), $value)->format('Y-m-d');

		} else {
			throw new \InvalidArgumentException();
		}

		if ($value !== NULL) {
			// DateTime constructor throws Exception when invalid input given
			try {
				$value = Nette\DateTime::from($value); // clone DateTime when given
			} catch (\Exception $e) {
				$value = NULL;
			}
		}

		if (!isset($rawValue) && isset($value)) {
			$rawValue = $value->format($this->toPhpFormat($this->format));
		}

		$this->value = $value;
		$this->rawValue = $rawValue;

		return $this;
	}



	/**
	 * Returns unfiltered value.
	 *
	 * @return   string
	 */
	public function getRawValue()
	{
		return $this->rawValue;
	}



	/**
	 * Does user enter anything? (the value doesn't have to be valid)
	 *
	 * @author   Jan Tvrdík
	 * @param    DatePicker
	 * @return   bool
	 */
	public static function validateFilled(\Nette\Forms\IControl $control)
	{
		if (!$control instanceof self) throw new \InvalidStateException('Unable to validate ' . get_class($control) . ' instance.');
		$rawValue = $control->rawValue;
		return !empty($rawValue);
	}



	/**
	 * Is entered value valid? (empty value is also valid!)
	 *
	 * @author   Jan Tvrdík
	 * @param    DatePicker
	 * @return   bool
	 */
	public static function validateValid(\Nette\Forms\IControl $control)
	{
		if (!$control instanceof self) throw new \InvalidStateException('Unable to validate ' . get_class($control) . ' instance.');
		$value = $control->value;
		return (empty($control->rawValue) || $value instanceof DateTime);
	}

	/**
	 * Is entered values within allowed range?
	 *
	 * @author   Jan Tvrdík
	 * @param    DatePicker
	 * @param    array             0 => minDate, 1 => maxDate
	 * @return   bool
	 */
	public static function validateDateRange(self $control, array $range)
	{
		return ($range[0] === NULL || $control->getValue() >= $range[0]) && ($range[1] === NULL || $control->getValue() <= $range[1]);
	}

	/**
	 * Finds minimum and maximum allowed dates.
	 *
	 * @author   Jan Tvrdík
	 * @param    Forms\Rules
	 * @return   array             0 => DateTime|NULL $minDate, 1 => DateTime|NULL $maxDate
	 */
	private function extractRangeRule(\Nette\Forms\Rules $rules)
	{
		$controlMin = $controlMax = NULL;

		foreach ($rules as $rule) {
			if ($rule->type === \Nette\Forms\Rule::VALIDATOR) {
				if ($rule->operation === self::DATE_RANGE && !$rule->isNegative) {
					$ruleMinMax = $rule->arg;
				}

			} elseif ($rule->type === \Nette\Forms\Rule::CONDITION) {
				if ($rule->operation === \Nette\Forms\Form::FILLED && !$rule->isNegative && $rule->control === $this) {
					$ruleMinMax = $this->extractRangeRule($rule->subRules);
				}
			}

			if (isset($ruleMinMax)) {
				list($ruleMin, $ruleMax) = $ruleMinMax;
				if ($ruleMin !== NULL && ($controlMin === NULL || $ruleMin > $controlMin)) $controlMin = $ruleMin;
				if ($ruleMax !== NULL && ($controlMax === NULL || $ruleMax < $controlMax)) $controlMax = $ruleMax;
				$ruleMinMax = NULL;
			}
		}
		return array($controlMin, $controlMax);
	}

	/**
	 * Converts js date format string to php date() format string
	 * @param type $str
	 * @return type
	 */
	function toPhpFormat ($str) {
		$f = $this->strReplace(
			array('dd',	'd',	'mm',	'm',	'MM',	'M',	'yyyy',	'yyy',	'yy'),
			array('d',	'j',	'm',	'n',	'F',	'M',	'Y',		'y',		'y'),
			$str
		);
		return $f;
	}

	/**
	 * Explode string to array using delimiter the same way as php explode do but includes delimiter in array
	 * @param string $del
	 * @param string $str
	 * @return array
	 */
	private function strToArray ($del, $str) {
		$a = array();
		foreach(explode($del[1], $str) as $t) {
			$a[] = $t;
			$a[] = $del[0];
		}
		array_pop($a);
		return $a;
	}

	/**
	 * String replace function. Works similar to php str_replace(array, array, string) but stops replacing when pattern found
	 *
	 * @param type $a1
	 * @param type $a2
	 * @param type $str
	 * @return type
	 */
	private function strReplace($a1, $a2, $str) {
		$tokens = (array)$str;
		foreach($a1 as $del_i => $p) {
			foreach ($tokens as $tok_i => $token) {
				if (is_string($token)) {
					if (count($new=$this->strToArray(array($del_i, $p), $token))>1) {
						array_splice ($tokens, $tok_i, 1, $new);
						break;
					}
				}
			}
		}
		foreach($tokens as &$token) {
			if(is_int($token)) $token = $a2[$token];
		}
		return implode('', $tokens);
	}
}
