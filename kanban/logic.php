<?php
function generPassword()
{
	$abc = array(
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
		'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
		'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
		'1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
	);
	$pass = "";
	$hasNumber = false;
	$hasUpCaseLetter = false;
	$hasLowerCaseLetter = false;
	while (!($hasNumber && $hasUpCaseLetter && $hasLowerCaseLetter))
	{
		$pass = "";
		$hasNumber = false;
		$hasUpCaseLetter = false;
		$hasLowerCaseLetter = false;
		for ($i = 0; $i < 8; $i++)
		{
			$letter = array_rand($abc);
			$pass = $pass.$abc[$letter];
			if ($letter < 26)
			{
				$hasLowerCaseLetter = true;
				
			}
			elseif ($letter < 52)
			{
				$hasUpCaseLetter = true;
			}
			else
			{
				$hasNumber = true;
			}
		}
	}
	return $pass;
}
function createLogin($value, $link)
{
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
	);
 
	$value = mb_strtolower($value);
	$value = strtr($value, $converter);
	$value = mb_ereg_replace('[^-0-9a-z]', '_', $value);
	$value = mb_ereg_replace('[_]+', '_', $value);
	$value = trim($value, '_');	
	$suff = "";
	$i = 0;
	$row = mysqli_fetch_row(mysqli_query($link, "SELECT count(login) from `parents`
	WHERE login LIKE '".$value."' LIMIT 1"));
	while($row[0] > 0)
								{
									$i++;
									$suff = $i;
									$row = mysqli_fetch_row(mysqli_query($link, "SELECT count(login) from `parents`
									WHERE login LIKE '".$value.$suff."' LIMIT 1"));
								}

	return $value.$suff;
}

