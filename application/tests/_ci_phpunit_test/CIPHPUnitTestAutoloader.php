<?php
/**
 * Part of CI PHPUnit Test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class CIPHPUnitTestAutoloader
{
	private $alias = [
		'MonkeyPatch',
		'ReflectionHelper',
	];

	/**
	 * @var CIPHPUnitTestFileCache
	 */
	private $cache;

	public function __construct(CIPHPUnitTestFileCache $cache = NULL)
	{
		$this->cache = $cache;
	}

	public function load($class)
	{
		if ($this->cache)
		{
			if ($this->loadFromCache($class))
			{
				return;
			}
		}

		$this->loadCIPHPUnitTestAliasClass($class);
		$this->loadCIPHPUnitTestClass($class);
		$this->loadApplicationClass($class);
	}

	protected function loadCIPHPUnitTestAliasClass($class)
	{
		if (in_array($class, $this->alias))
		{
			$dir = __DIR__ . '/alias';
			$this->loadClassFile($dir, $class);
		}
	}

	protected function loadCIPHPUnitTestClass($class)
	{
		if (substr($class, 0, 13) !== 'CIPHPUnitTest')
		{
			return;
		}

		if (substr($class, -9) !== 'Exception')
		{
			$dir = __DIR__;
			$this->loadClassFile($dir, $class);
		}
		else
		{
			$dir = __DIR__ . '/exceptions';
			$this->loadClassFile($dir, $class);
		}
	}

	protected function loadApplicationClass($class)
	{
		$dirs = [
			APPPATH.'libraries',
			APPPATH.'controllers',
			APPPATH.'models',
		];

		foreach ($dirs as $dir)
		{
			if ($this->loadClassFile($dir, $class))
			{
				return TRUE;
			}

			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator(
					$dir, \RecursiveDirectoryIterator::SKIP_DOTS
				),
				\RecursiveIteratorIterator::SELF_FIRST
			);

			foreach ($iterator as $file)
			{
				if ($file->isDir())
				{
					if ($this->loadClassFile($file, $class))
					{
						return TRUE;
					}
				}
			}
		}
	}

	protected function loadClassFile($dir, $class)
	{
		$class_file = $dir . '/' . $class . '.php';
		if (file_exists($class_file))
		{
			require $class_file;
			if ($this->cache)
			{
				$this->cache[$class] = $class_file;
			}
			return TRUE;
		}
		
		return FALSE;
	}

	protected function loadFromCache($class)
	{
		if ($filename = $this->cache[$class])
		{
			if (is_readable($filename))
			{
				require $filename;
				return TRUE;
			}
			else
			{
				unset($this->cache[$class]);
			}
		}
		
		return FALSE;
	}
}
