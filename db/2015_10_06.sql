CREATE TABLE  address (
id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
addrstring VARCHAR( 255 ) NULL DEFAULT NULL ,
aoid VARCHAR( 255 ) NULL ,
houseid VARCHAR( 255 ) NULL ,
country_id INT( 11 ) NULL ,
postalcode VARCHAR( 15 ) NULL ,
country_code VARCHAR( 3 ) NULL ,
additional VARCHAR( 255 ) NULL ,
object VARCHAR( 20 ) NOT NULL ,
object_id INT( 11 ) NOT NULL ,
INDEX (  country_id ,  country_code ,  object ,  object_id ));



DROP TABLE IF EXISTS d_fias_addrobj;
CREATE TABLE IF NOT EXISTS d_fias_addrobj (
  aoid char(36) NOT NULL COMMENT 'Уникальный идентификатор записи',
  formalname varchar(120) NOT NULL COMMENT 'Формализованное наименование',
  regioncode varchar(2) NOT NULL COMMENT 'Код региона',
  autocode char(1) NOT NULL COMMENT 'Код автономии',
  areacode varchar(3) NOT NULL COMMENT 'Код района',
  citycode varchar(3) NOT NULL COMMENT 'Код города',
  ctarcode varchar(3) NOT NULL COMMENT 'Код внутригородского района',
  placecode varchar(3) NOT NULL COMMENT 'Код населенного пункта',
  streetcode varchar(4) NOT NULL COMMENT 'Код улицы',
  extrcode varchar(4) NOT NULL COMMENT 'Код дополнительного адресообразующего элемента',
  sextcode varchar(3) NOT NULL COMMENT 'Код подчиненного дополнительного адресообразующего элемента',
  offname varchar(120) NOT NULL COMMENT 'Официальное наименование',
  postalcode char(6) NOT NULL COMMENT 'Почтовый индекс',
  ifnsfl varchar(4) NOT NULL COMMENT 'Код ИФНС ФЛ',
  terrifnsfl varchar(4) NOT NULL COMMENT 'Код территориального участка ИФНС ФЛ',
  ifnsul varchar(4) NOT NULL COMMENT 'Код ИФНС ЮЛ',
  terrifnsul varchar(4) NOT NULL COMMENT 'Код территориального участка ИФНС ЮЛ',
  okato varchar(11) NOT NULL COMMENT 'ОКАТО',
  oktmo varchar(8) NOT NULL COMMENT 'ОКТМО',
  updatedate date NOT NULL COMMENT 'Дата  внесения записи',
  shortname varchar(10) NOT NULL COMMENT 'Краткое наименование типа объекта',
  aolevel int(10) unsigned NOT NULL COMMENT 'Уровень адресного объекта ',
  parentguid char(36) NOT NULL COMMENT 'Идентификатор объекта родительского объекта',
  aoguid varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор адресного объекта',
  previd varchar(36) NOT NULL COMMENT 'Идентификатор записи связывания с предыдушей исторической записью',
  nextid varchar(36) NOT NULL COMMENT 'Идентификатор записи  связывания с последующей исторической записью',
  code varchar(17) NOT NULL COMMENT 'Код адресного объекта одной строкой с признаком актуальности из КЛАДР 4.0',
  plaincode varchar(15) NOT NULL COMMENT 'Код адресного объекта из КЛАДР 4.0 одной строкой без признака актуальности (последних двух цифр)',
  actstatus tinyint(3) unsigned NOT NULL COMMENT 'Статус актуальности адресного объекта ФИАС. Актуальный адрес на текущую дату. Обычно последняя запись об адресном объекте.',
  centstatus int(10) unsigned NOT NULL COMMENT 'Статус центра',
  operstatus int(10) unsigned NOT NULL COMMENT 'Статус действия над записью – причина появления записи',
  currstatus int(10) unsigned NOT NULL COMMENT 'Статус актуальности КЛАДР 4 (последние две цифры в коде)',
  startdate date NOT NULL COMMENT 'Начало действия записи',
  enddate date NOT NULL COMMENT 'Окончание действия записи',
  normdoc varchar(36) NOT NULL COMMENT 'Внешний ключ на нормативный документ',
  PRIMARY KEY (aoid),
  KEY parentguid (parentguid),
  KEY aoguid (aoguid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Классификатор адресообразующих элементов';

-- --------------------------------------------------------

--
-- Структура таблицы d_fias_house
--

DROP TABLE IF EXISTS d_fias_house;
CREATE TABLE IF NOT EXISTS d_fias_house (
  postalcode char(6) NOT NULL COMMENT 'Почтовый индекс',
  ifnsfl varchar(4) NOT NULL COMMENT 'Код ИФНС ФЛ',
  terrifnsfl varchar(4) NOT NULL COMMENT 'Код территориального участка ИФНС ФЛ',
  ifnsul varchar(4) NOT NULL COMMENT 'Код ИФНС ЮЛ',
  terrifnsul varchar(4) NOT NULL COMMENT 'Код территориального участка ИФНС ЮЛ',
  okato varchar(11) NOT NULL COMMENT 'ОКАТО',
  oktmo varchar(8) NOT NULL COMMENT 'ОКTMO',
  updatedate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата время внесения записи',
  housenum varchar(20) NOT NULL COMMENT 'Номер дома',
  eststatus int(10) unsigned NOT NULL COMMENT 'Признак владения',
  buildnum varchar(10) NOT NULL COMMENT 'Номер корпуса',
  strucnum varchar(10) NOT NULL COMMENT 'Номер строения',
  strstatus int(10) unsigned NOT NULL COMMENT 'Признак строения',
  houseid char(36) NOT NULL COMMENT 'Уникальный идентификатор записи дома',
  houseguid varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор дома',
  aoguid varchar(36) NOT NULL COMMENT 'Guid записи родительского объекта',
  startdate date NOT NULL COMMENT 'Начало действия записи',
  enddate date NOT NULL COMMENT 'Окончание действия записи',
  statstatus int(10) unsigned NOT NULL COMMENT 'Состояние дома',
  normdoc varchar(36) NOT NULL COMMENT 'Внешний ключ на нормативный документ',
  counter int(10) unsigned NOT NULL COMMENT 'Счетчик записей домов для КЛАДР 4',
  PRIMARY KEY (houseid),
  KEY aoguid (aoguid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Сведения по номерам домов улиц городов и населенных пунктов,';