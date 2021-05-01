<?php

namespace FigTree\Config;

use Throwable;
use FigTree\Config\Contracts\ConfigReaderInterface;
use FigTree\Config\Exceptions\InvalidConfigFileException;

class ConfigReader implements ConfigReaderInterface
{
	/**
	 * Read the contents of the Config file.
	 *
	 * @return array
	 */
	public function read(string $filename): array
	{
		ob_start();

		try {
			$data = (require $filename);
		} catch (Throwable $exc) {
			throw new InvalidConfigFileException($filename, 0, $exc);
		} finally {
			ob_end_clean();
		}

		if (!is_array($data)) {
			throw new InvalidConfigFileException($filename);
		}

		return $data;
	}
}
