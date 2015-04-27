DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
        searches/         contains search models
      modules/            contains app modules
        staff/
          views/          views for staff module
          controllers/    controllers for staff module
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources


Това е базовата структура на приложението. Качените файлове представят частта за училищата в администраторския модул. 
В нея могат да се администрират училища и видове училища. За целта в базата данни са създадени 3 таблици - school, 
school_type и type_to_school. Връзката между училищата и видовете е много към много. Създадени са и моделите, представляващи
данните в тези таблици, съответно School, SchoolType, TypeToSchool. Те наследяват базовия клас на фреймуорка ActiveRecord. В тях
се съдържат rules() метода за валидации във формите, attributeLabels() за label–ите във формите, както и методи, дефиниращи релации
като например getSchoolTypes() в School модела, който описва релацията между училищата и типовете с помощта на свързваща таблица:
    public function getSchoolTypes()
    {
         return $this->hasMany(SchoolType::className(), ['id' => 'type_id'])
            ->viaTable('type_to_school', ['school_id' => 'id']);
    }
type_id и school_id за колони в type_to_school таблицата и се свързват с id-тата на school и type_to school.

Във modules/staff/views/ са разположени view файловете. index.php файловете представят таблици (gridview) с всички записи и филтри. Филтрите се
обработват от search model-и, разположени в models/searches/. За update на gridview-тата е изпозвана техниката PJAX (push state and ajax).
Таблиците са обградени от PJAX контейнер като всеки линк в него изпраща AJAX request. В отговор на AJAX request-а, PJAX изпраща промененото
съдържание на контейнера (базиран на AJAX request) към клиента и променя старото съдържание с ново. Разликата с AJAX е, че URL-а ще бъде 
променен чрез pushState.
    <?php Pjax::begin(['id' => 'schools-container', 'options' => ['class' => 'pjax-wrapper']]) ?>
	...
    <?php Pjax::end() ?>
Останалите view файлове се зареждат в modal, който е разположен в базовия layout. При кликване на бутона за добавяне, промяна или преглед
на училище, съдържанието на create.php, update.php и view.php във staff/views/school/ се зарежда с AJAX функцията на jQuery $.get() като 
заявката се праща към url, взет от стойността на атрибута href на линковете. За показване на view файловете и подготвянето на данните в тях,
се грижи modules/staff/controllers/SchoolController. Методите, които ще служат за показване на view-та наричат action-и, като например метода 
actionCreate(), който отговаря за показването на формата за добавяне на училище. Той се достъпва със следния url: /staff/school/create.html. 
Този метод зарежда staff/views/school/create.php файла чрез метода renderAjax(). Това означава, че ще се зареди в модала само файла, без 
layout–а на сайта, но в същото време ще се заредят необходимите js и css файлове, което ще спомогне за правилното показване и пращане 
на формата. Ако се използва метода render(), ще бъде зареден файла с целия layout на сайта, както в случая с actionIndex(). В тези методи
като параметър е достатъчно да се зададе само името на файла, например 'index', което означава, че ще се зареди index.php файлът
в modules/staff/views/school/. 
Изпращането на формите при create и update отново става с ajax request с помощта на jQuery функцията $.post() в submitForm(). И двете view-та
използват _form.php файла, който съдържа формата. Разликата е, че при update контролера (чрез метода actionUpdate()) ще зададе стойности на 
атрибутите на обекта, които ще бъдат попълнени в input полетата. Във _form.php се намира и js кода за изпращане нa формата чрез AJAX. 
За целта се блокира нормалното изпращене на формата, сериализира се, валидира се с помощта на валидациите от клиентската страна и ajax
и ако ги премине успешно се изпраща. След това модалът се затваря и се ъпдейтва Pjax контейнерът с таблицата с училищата:
	$.pjax.reload({container:'#schools-container'});
Всички Html елементи се генерират с php код с помощта на базови класове във фреймуорка, като например ActiveForm, Html, GridView. 
Аналогичен е процесът при администриране на видовете училища.

