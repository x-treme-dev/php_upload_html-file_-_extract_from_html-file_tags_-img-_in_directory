 <form action="#" method='post' enctype="multipart/form-data">
     Выберите файлы
	 <br>
	 <!-- Поле MAX_FILE_SIZE требуется указывать перед полем загрузки файла -->
         <!--<input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
	 <input type="file" name='file' accept="text/html">
	 <br>
	 <br>
	 <input type="submit" value="Загрузить файлы">
	 <br>
	 <br>
	 
	 
	    
		   <!--
			* Создать форму, в которую можно загружать html-файлы. 
			* Сохранять каждый файл с уникальным именем, содержащим только латинские буквы и цифры + расширение html.
			* В содержимом файла искать все картинки (<img>) и скачивать их
			* в отдельную папку. По итогу работы выводить фразу "Обработано N картинок".
		   -->
</form>


<?php
      // создать имя из букв и цифр с расширением .html
      function toRename():string{
	      $str_name = '';
              $arr_numb = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
	      $arr_symb = ['a', 'A', 'B', 'c', 'D', 'e', 'f', 'g', 'h', 'y'];
	      for($i = 0;$i < 5; $i++){
	         $str_name .= $arr_numb[mt_rand(0,9)];
	         $str_name .= $arr_symb[mt_rand(0, 9)];
	      }
            return $str_name . '.html';
      }

        $file_name = toRename(); // сохранить новое имя файла
	$uploaddir = __DIR__ . '\files\\';
	$uploadfile = $uploaddir . basename( $file_name);
	echo '<pre>';
	if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
		echo "Файл не содержит ошибок и успешно загрузился на сервер.\n";
	} else {
		echo "Возможная атака на сервер через загрузку файла!\n";
	}

	
	//echo 'Дополнительная отладочная информация:';
	//print_r($_FILES);
	//print "</pre>";
	// взять html-файл и достать из него теги img
	// посчитать из вывести на страницу
	$html = file_get_contents($uploadfile);
	$doc = new DOMDocument();
	@$doc -> loadHTML($html);
	$tags = $doc->getElementsByTagName('img');
	echo '<div style="display:flex;flex-wrap:wrap;">';
        $count = 0;
	foreach($tags as $tag){
		echo '<img src="' . $tag->getAttribute('src') . '"  style="width:300;">'. '<br>';
		$count++;
	}
        echo '</div>';
      echo '<h1>In direcory ' . $count . ' photos</h1>';
?>
