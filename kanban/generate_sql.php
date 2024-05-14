<?
// Метод getRecords

// Этот метод позволяет получить набор записей, которые подходят под условие нашего SQL.

// $what — передает массив полей, которые нужно выбрать из таблицы
// $where — передает ассоциативный массив ключей в виде array('Поле'=>array('знак','значение')). Это дает нам возможность более гибко использовать предикат WHERE
// $limit — передает ассоциативный массив ключей в виде array('начальная запись', 'количество записей'). Такая структура дает нам возможность реализовать постраничный вывод или вывод ограниченного количества записей
// $order — ассоциативный массив array('поле'=>'вид сортировки'). Дает возможность сортировки по любому количеству столбцов.
// $join — ассоциативный массив array('Тип связи', array('Таблица1', 'Таблица2'), array('Алиас1', 'Алиас2'), array('поле1','поле2')). Тип связи: LEFT, INNER, RIGHT, OUTER; Таблица1 и Таблица2: таблицы между которыми устанавливается связь; Аллиас1 и Аллиас2 — псевдонимы для таблицы; Поле1 и Поле2 — это соотв. PK и FK таблиц
// $degub — этот параметр нужен для сохранения в свойства класса уже созданного sql запроса, а также параметров, которые нужно если мы используем prepare statement в PDO

// Метод addRecord

// Этот метод позволяет добавить запись в таблицу.
// $data — ассоциативный массив параметров в виде: 'поле'=>'значение', которые будут вставляться в таблицу

// Метод deleteRecords

// Этот метод позволяет удалить запись (-и) из таблицы.
// $table — название таблицы из которой будут удаляться данные

// Метод setRecords

// Этот метод позволяет обновить запись (-и) в таблице по заданному условию.
// $what — В этом случает этот параметр передает массив в виде: 'поле'=>'значение', которые будут использоваться с оператором SET


      function addJoin($tables,$pseudoName,$rows, $type=' INNER ',)
    {
        if ($type!=='' && is_array($tables) && is_array($rows))
        {
            $t0=$tables[0];
            $t1=$tables[1];
            if (is_array($pseudoName) && count($pseudoName)>0)
            {
                $t0=$pseudoName[0];
                $t1=$pseudoName[1];
            }
            return $type." JOIN `".$tables[1]."` `".$pseudoName[1]."` ON `".$t0."`.`".$rows[0]."`=`".$t1."`.`".$rows[1]."`";
        }
        else {
            return false;
        }
    }

    /*
     * Добавляем несколько join к запросу
     * join - массив массивов join array(join,join)
     * */

     function addJoinArray($join)
    {
        if (is_array($join))
        {
            foreach ($join as $j)
            {
                $res[]=addJoin($j[0],$j[1],$j[2],$j[3]);
            }
        }
        return $res;

    }

    /*
     * Генерируем SELECT sql
     * what- поля которые нужно выбрать в виде массива
     * where- условие выбора в виде массива array(поле=>array(знак=,значение))
     * limit-лимит записей в виде массива array(начальная запись, количество)
     * order- сортировка array (поле=>направление)
     * join- массив join
     * debug- если true то в свойство класса sql записывается текущий sql запрос и в свойство params записываются параметры
     * */

     function prepareSelectSQL($table,$what=array('*'),$where=NULL, $limit=NULL, $order=NULL,$join=NULL,$debug=false)
    {
        $what=checkWhat($what);
        $where=checkWhere($where);
        $limit=checkLimit($limit);
        $order=checkOrder($order);
        $j=checkJoin($join);

        $sql="SELECT ".$what['column']." FROM `".$table."` `tb` ".$j." ".$where['column']." ".$order." ".$limit;
        $params=checkParams($what['params'],$where['params']);
        if ($debug)
        {
            $sql=$sql;
            $params=$params;
        }
        return $sql;
    }

    /*
     * Генерируем Insert sql
     * data- массив пар поле-значение для вставки
     * table- таблица куда вставляется значение
     * debug- если true то в свойство класса sql записывается текущий sql запрос и в свойство params записываются параметры
     * */

     function prepareInsertSQL($data,$table,$debug=false)
    {
        foreach ($data as $c=>$p)
        {
            if ($c!='okadd'){
                $column[]="`".$c."`";
                $values[]="'".$p."'";
            }
        }

        $sql=" INSERT INTO `".$table."` (".implode(",",$column).") VALUES (".implode(',',$values).")";
        if ($debug)
        {
            $sql=$sql;
        }
        return $sql;
    }

    /*
     * Генерируем Delete sql
     * where- Условие для удаления
     * table- таблица из которой удаляются записи
     * debug- если true то в свойство класса sql записывается текущий sql запрос и в свойство params записываются параметры
     * */

     function prepareDeleteSQL($table,$where,$debug=false)
    {
        $where=checkWhere($where);
        $sql="DELETE FROM `".$table."` ".$where['column'];
        $params=checkParams($what,$where['params']);
        if ($debug)
        {
            $sql=$sql;
            $params=$params;
        }
        return $sql;
    }

    /*
     * Генерируем Update sql
     * table- таблица из которой удаляются записи
     * what - массив поле значение для обновления
     * where- Условие для обновления
     * debug- если true то в свойство класса sql записывается текущий sql запрос и в свойство params записываются параметры
     */

     function prepareUpdateSQL($table,$what,$where,$debug=false)
    {
        $what=checkWhat($what);
        $where=checkWhere($where);
        $sql="UPDATE `".$table."` SET ".$what['column']." ".$where['column'];
        $params=checkParams($what['params'],$where['params']);
        if ($debug)
        {
            $sql=$sql;
            $params=$params;
        }
        return $sql;

    }

    /*
     * Проверяем наличие параметра join
     * Если он есть, то проверяем является ли он единственным, если да то addJoin
     * если нет, то addJoinArray
     * Если join нет, то ничего не возвращаем
     * */

     function checkJoin($join)
    {
        if (is_array($join) && count($join)>0)
        {
            if (!is_array($join[0]))
            {
                $res[]=addJoin($join[0],$join[1],$join[2],$join[3]);
            }
            else {
                $res=addJoinArray($join);
            }
            return implode(" ",$res);
        }
        else {
            return false;
        }
    }

    /*
     * Проверяем наличие параметра what
     * Если этот параметр явл. массивом,
     * то генерируем массив поле=>? и массив параметров для prepare SQL
     * */

     function checkWhat($what)
    {
        if (is_array($what))
        {
            foreach ($what as $k=>$v)
            {
                    if (!is_numeric($k))
                    {
                        if ( $k != 'okedit') {
                            $result['column'][]="`".$k."`"."="."'".$v."'";
                        }
                    }
                    else {
                        $result['column'][]=$v;
                    }
            }
            $result['column']=implode(",",$result['column']);
        }
        return $result;
    }

    /*
     * Проверяем наличие параметра Where
     * Если этот параметр явл массивом,
     * то генерируем массив поле=>? и массив параметров для prepare SQL
     * если v[0](sign)= IN и значение value это массив, то можно сгенерировать IN (array);
     * Можно также генерировать условие LIKE, но не тестил.
     * Возвращает массив полей и параметров для sql
     * */

     function checkWhere($where)
    {
        if (!is_null($where) && is_array($where))
        {
            foreach ($where as $k=>$v)
            {
                $part="`".$k."`".$v[0];
                if (!is_array($v[1]))
                {
                    $part.="'".$v[1]."'";
                }
                else {
                    $part.="(".implode(",",$v[1]).")";
                }
                $res[]=$part;

            }
            $result['column']="WHERE ".implode(" AND ",$res);
        }

        return $result;
    }

    /*
     * Проверяем наличие параметра Limit
     * Если этот параметр явл массивом,
     * то генерируем LIMIT для SQL
     * Возвращает строку LIMIT  с разбиением на страницы или без него
     * */

     function checkLimit($limit)
    {
        if (is_array($limit) && count($limit)>0)
        {
            $res=" LIMIT ".$limit['start'];
            if (isset($limit['count']) && $limit['count']!=='')
            {
                $res.=", ".$limit['count'];
            }
        }
        return $res;
    }

    /*
     * Проверяем наличие параметра Order
     * Если этот параметр явл массивом,
     * то генерируем ORDER для SQL
     * Возвращает массив ORDER
     * */

     function checkOrder($order)
    {
        if (is_array($order) && count($order)>0)
        {
            foreach ($order as $row=>$dir)
            {
                $res[]=$row." ".$dir;
            }
            return "ORDER BY ".implode(",",$res);
        }
        else {
            return '';
        }
    }

    /*
     * Проверяем наличие параметров для prepare sql
     * Параметры состоят из массива параметров WHAT и массива параметров WHERE.
     * Это нужно для того, чтобы prepare sql
     * работал и с update, select, delete, insert
     * Объединяет два массива what и where
     * */

     function checkParams($what,$where)
    {
        if (!isset($what) || !is_array($what))
        {
            $params=$where;
        }
        else if (!isset($where) && !is_array($where))
        {
            $params=$what;
        }
        else {
            $params=array_merge($what,$where);
        }
        return $params;
    }
     function getRecords($table,$what=array('*'),$where=NULL, $limit=NULL, $order=NULL,$join=NULL,$debug=false)
    {
        $data=prepareSelectSQL($table, $what,$where, $limit, $order,$join,$debug);
        return $data;

    }
        function addRecord($table, $data=array(),$debug=false)
    {
        $data=prepareInsertSQL($data,$table,$debug);
        return $data;
    }

        function deleteRecords($table, $where=NULL,$debug=false)
    {
        $data=prepareDeleteSQL($table,$where,$debug);
        return $data;
    }

        function setRecords($table,$what,$where,$debug=false)
    {
        $data=prepareUpdateSQL($table,$what,$where,$debug);
        return $data;
    }

        function query($sql)
    {
        $query=prepare($sql);
        return $data;
    }
?>