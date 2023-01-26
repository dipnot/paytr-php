<?php
namespace Dipnot\PayTR\Model;

/**
 * Class Currency
 *
 * @see https://www.paytr.com/sikca-sorulan-sorular > C.1.7
 */
abstract class Currency
{
	const TL = "TRY";
	const USD = "USD";
	const EUR = "EUR";
	const GBP = "GBP";
	const RUB = "RUB";
}