<?php declare(strict_types=1);

/* ==== LICENCE AGREEMENT =====================================================
 *
 * © Cédric Ducarre (20/05/2010)
 * 
 * wlib is a set of tools aiming to help in PHP web developpement.
 * 
 * This software is governed by the CeCILL license under French law and
 * abiding by the rules of distribution of free software. You can use, 
 * modify and/or redistribute the software under the terms of the CeCILL
 * license as circulated by CEA, CNRS and INRIA at the following URL
 * "http://www.cecill.info".
 * 
 * As a counterpart to the access to the source code and rights to copy,
 * modify and redistribute granted by the license, users are provided only
 * with a limited warranty and the software's author, the holder of the
 * economic rights, and the successive licensors have only limited
 * liability.
 * 
 * In this respect, the user's attention is drawn to the risks associated
 * with loading, using, modifying and/or developing or reproducing the
 * software by the user in light of its specific status of free software,
 * that may mean that it is complicated to manipulate, and that also
 * therefore means that it is reserved for developers and experienced
 * professionals having in-depth computer knowledge. Users are therefore
 * encouraged to load and test the software's suitability as regards their
 * requirements in conditions enabling the security of their systems and/or 
 * data to be ensured and, more generally, to use and operate it in the 
 * same conditions as regards security.
 * 
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL license and that you accept its terms.
 * 
 * ========================================================================== */

/**
 * Get a text translation.
 * 
 * Usage :
 * 
 * ```
 * echo __('Hello world'); // will search localized string from "default" domain
 * echo __('Hello world', 'mydomain'); // will search in "mydomain" domain.
 * ```
 * 
 * @param string $sText Text to translate.
 * @param string $sDomain Use to get the translated string from the specified domain.
 */
function __(string $sText, string $sDomain = ''): string
{
	if (!isset($GLOBALS[wlib\I18n\Translator::class]))
		return $sText;

	/** @var wlib\I18n\Translator $translator */
	$translator = $GLOBALS[wlib\I18n\Translator::class];
	return $translator->translate($sText, $sDomain);
}

/**
 * Get a singular or plural translation based on a number value.
 * 
 * @param string $sSingular Singular text form.
 * @param string $sPlural Plural text form.
 * @param int $iCount Count number for choosing between singular or plural.
 * @param string $sDomain Text domain.
 * @return string
 */
function _n(string $sSingular, string $sPlural, int $iCount, string $sDomain = ''): string
{
	if (!isset($GLOBALS[wlib\I18n\Translator::class]))
		return ($iCount > 1 ? $sPlural : $sSingular);

	/** @var wlib\I18n\Translator $translator */
	$translator = $GLOBALS[wlib\I18n\Translator::class];
	return $translator->translatePlural($sSingular, $sPlural, $iCount, $sDomain);
}