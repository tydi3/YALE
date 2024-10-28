<?php //*** HtmlX » Tydi™ Framework © 2024 ∞ AO™ • @osawereao • www.osawere.com ∞ Apache License ***//
namespace App\Spry;

class HtmlX
{
	// • ==== trimParagraph • remove empty paragraph »
	public static function trimParagraph($html)
	{
		return preg_replace('/<p>\s*<\/p>/', '', $html);
	}





	// • ==== nl2brp • convert newline to line break or paragraph »
	public static function nl2brp($html)
	{
		$html = trim($html);
		$lines = explode("\n\n", $html);
		if (!empty($lines) && is_array($lines)) {
			$html = '';
			foreach ($lines as $index => $line) {
				if ($index < 1) {
					if (StringX::hasNL($line)) {
						$html .= nl2br($line);
					} else {
						$html .= $line;
					}
				}

				if ($index > 0) {
					$html .= '<p>' . nl2br($line) . '</p>';
				}

				$html = self::trimParagraph($html);
			}
		}
		return $html;
	}

} //> end of HtmlX