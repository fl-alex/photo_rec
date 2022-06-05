<?php // обработка загрузки файлов на сервер
                                
$input_name = 'file';
// Расширения файлов.
$allow = array();
$deny = array();
$max_size = 1;
 
// Директория куда будут загружаться файлы.

if (isset($_REQUEST['dir_upl'])) {
    $path = __DIR__ . '/'.$_REQUEST['dir_upl'].'/';
}
else {
    //$path = __DIR__ . '/img/';
}

 
if (isset($_FILES[$input_name])) {

	if (!is_dir($path)) {
		mkdir($path, 0777, true);
	}
 
	// Преобразуем массив $_FILES в удобный вид для перебора в foreach.
	$files = array();
	$diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);
	if ($diff == 0) {
		$files = array($_FILES[$input_name]);
	} else {
		foreach($_FILES[$input_name] as $k => $l) {
			foreach($l as $i => $v) {
				$files[$i][$k] = $v;
			}
		}		
	}	
	
	foreach ($files as $file) {
		$error = $success = '';		
		if (!empty($file['error']) || empty($file['tmp_name'])) {
			switch (@$file['error']) {
				case 1:
                                case 2: $error = getIp()."| ".'error 2| Превышен размер загружаемого файла| '.$file['name']; break;
				case 3: $error = getIp()."| ".'error 3| Файл был получен только частично.'; break;
				case 4: $error = getIp()."| ".'error 4| Файл не был загружен.'; break;
				case 6: $error = getIp()."| ".'error 6| Файл не загружен - отсутствует временная директория.'; break;
				case 7: $error = getIp()."| ".'error 7| Не удалось записать файл на диск.'; break;
				case 8: $error = getIp()."| ".'error 8| PHP-расширение остановило загрузку файла.'; break;
				case 9: $error = getIp()."| ".'error 9| Файл не был загружен - директория не существует.'; break;
				case 10: $error = getIp()."| ".'error 10| Превышен максимально допустимый размер файла.'; break;
				case 11: $error = getIp()."| ".'error 11| Данный тип файла запрещен.'; break;
				case 12: $error = getIp()."| ".'error 12| Ошибка при копировании файла.'; break;
				default: $error = getIp()."| ".'Файл не был загружен - неизвестная ошибка.'; break;
			}
		} elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
			$error = 'Не удалось загрузить файл.';
		} else {
			// Оставляем в имени файла только буквы, цифры и некоторые символы.
			$pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
			$name = mb_eregi_replace($pattern, '-', $file['name']);
			$name = mb_ereg_replace('[-]+', '-', $name);
			
			// Т.к. есть проблема с кириллицей в названиях файлов (файлы становятся недоступны).
			// Сделаем их транслит:
			$converter = array(
				'а' => 'a',   'б' => 'b',   'в' => 'v',    'г' => 'g',   'д' => 'd',   'е' => 'e',
				'ё' => 'e',   'ж' => 'zh',  'з' => 'z',    'и' => 'i',   'й' => 'y',   'к' => 'k',
				'л' => 'l',   'м' => 'm',   'н' => 'n',    'о' => 'o',   'п' => 'p',   'р' => 'r',
				'с' => 's',   'т' => 't',   'у' => 'u',    'ф' => 'f',   'х' => 'h',   'ц' => 'c',
				'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',  'ь' => '',    'ы' => 'y',   'ъ' => '',
				'э' => 'e',   'ю' => 'yu',  'я' => 'ya', 
			
				'А' => 'A',   'Б' => 'B',   'В' => 'V',    'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
				'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',    'И' => 'I',   'Й' => 'Y',   'К' => 'K',
				'Л' => 'L',   'М' => 'M',   'Н' => 'N',    'О' => 'O',   'П' => 'P',   'Р' => 'R',
				'С' => 'S',   'Т' => 'T',   'У' => 'U',    'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
				'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',  'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
				'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
			);
 
			$name = strtr($name, $converter);
			$parts = pathinfo($name);
                        
			if (empty($name) || empty($parts['extension'])) {
				$error = 'Недопустимое тип файла';
			} elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
				$error = 'Недопустимый тип файла '.$name." - ". filesize($name);
			} elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
				$error = 'Недопустимый тип файла';                        
			} else {
				// Чтобы не затереть файл с таким же названием, добавим префикс.
				$i = 0;
				$prefix = '';
				while (is_file($path . $parts['filename'] . $prefix . '.' . $parts['extension'])) {
		  			$prefix = '(' . ++$i . ')';
				}
				$name = $parts['filename'] . $prefix . '.' . $parts['extension'];
 
				// Перемещаем файл в директорию.
				if (move_uploaded_file($file['tmp_name'], $path . $name)) {
					// Далее можно сохранить название файла в БД и т.п.
					$success = getIp()."| ".$path.$name;
				} else {
					$error = 'Не удалось загрузить файл '.$name." - ". filesize($name);
				}
			}
		}
		
		// Выводим сообщение о результате загрузки.
		if (!empty($success)) {
                    file_put_contents(__DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] ').$success. PHP_EOL, FILE_APPEND | LOCK_EX);
			echo json_encode(array('success'=>$success,'filename'=>$name));		
		} else {
                        echo json_encode(array('error'=>$error));
                        file_put_contents($path = __DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] ').$error. PHP_EOL, FILE_APPEND | LOCK_EX);
                
		}
	}
        
}


function getIp() {
  $keys = [
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED_FOR',
    'REMOTE_ADDR'
  ];
  foreach ($keys as $key) {
    if (!empty($_SERVER[$key])) {
      $ip = trim(end(explode(',', $_SERVER[$key])));
      if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
      }
    }
  }
}
        ?>