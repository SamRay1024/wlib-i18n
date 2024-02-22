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

namespace wlib\I18n;

use POMO\MO;
use POMO\Translations\NOOPTranslations;
use POMO\Translations\TranslationsInterface;
use RuntimeException;

/**
 * Wrapper class over pomo/pomo classes to manage translations in your application.
 * 
 * @author Cédric Ducarre
 */
class Translator
{
	/**
	 * List of availables translations files.
	 * @var array
	 */
	private array $aTranslations;

	public function __construct()
	{
		// This "hacks", used for helpers, can cause problems if the class is
		// instanciated several times
		$GLOBALS[self::class] = $this;
	}

	/**
	 * Add a translation file (.po).
	 * 
	 * @param string $sFilename File path an name of a .po file to load.
	 * @param mixed $sDomain Translation domain ('default' if unused).
	 * @return void
	 */
	public function addTranslationsFile(string $sFilename, string $sDomain = 'default')
	{
		if (!is_file($sFilename) || !is_readable($sFilename))
			throw new RuntimeException(sprintf(
				'File "%s" not found or not readable.',
				$sFilename
			));

		$translations = new MO();
		$translations->import_from_file($sFilename);

		if (!isset($this->aTranslations[$sDomain]))
		{
			$this->aTranslations[$sDomain] = $translations;
		}
		else
		{
			/** @var MO $prevTranslation */
			$prevTranslation = $this->aTranslations[$sDomain];
			$prevTranslation->merge_with($translations);
		}
	}
	
	/**
	 * Get the translation of the given text.
	 *
	 * @param string $sText Text to translate.
	 * @param string $sDomain Text domain.
	 * @param string|null $sContext Context information for translators.
	 * @return string
	 */
	public function translate(
		string $sText, string $sDomain = 'default', ?string $sContext = null
	): string
	{
		$translations = $this->getDomainTranslation($sDomain);

		return $translations->translate($sText, $sContext);
	}

	/**
	 * Get the singular or plural form of the given texts based on the supplied count.
	 *
	 * @param string $sSingular Singular text form.
	 * @param string $sPlural Plural text form.
	 * @param int $iCount Count number for choosing between singular or plural.
	 * @param string $sDomain Text domain.
	 * @param string|null $sContext Context information for translators.
	 * @return string
	 */
	public function translatePlural(
		string $sSingular, string $sPlural, int $iCount,
		string $sDomain = 'default', ?string $sContext = null
	): string
	{
		$translations = $this->getDomainTranslation($sDomain);
		return $translations->translate_plural($sSingular, $sPlural, $iCount, $sContext);
	}
	
	/**
	 * Get the translation instance associated to the given domain.
	 *
	 * @param string $sDomain Texts domain.
	 * @return TranslationsInterface
	 */
	private function getDomainTranslation(string $sDomain): TranslationsInterface
	{
		$sDomain = ($sDomain ?: 'default');

		if (!isset($this->aTranslations[$sDomain]))
			return new NOOPTranslations();

		return $this->aTranslations[$sDomain];
	}
}