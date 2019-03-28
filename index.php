<?php
    require_once("configDB.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Additional CSS-->
    <link rel="stylesheet" href="styles.css">

    <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
    <script src="html5sortable.js"></script>

    <title>Конструктор уроков</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  </head>
  <body>

<header class="container p-3">
  <h1>Конструктор уроков</h1>
  <p>Предлагаемые приемы педагогической техники могут быть успешно использованы в любой предметной области, так как являются универсальными. Легко встраиваются в уроки любого типа и могут быть использованы на разных этапах урока. Используемые в работе элементы «Конструктора урока»  (автор Анатолий Гин) могут быть дополнены личными находками учителя.</p>
</header>


    <section class="container row m-3 ml-auto mr-auto">

      <section class="container card_collapse col-12 col-md-6">

      <!--Разделы урока-->
      <section class="border-bottom row pb-2 col-md-12">
      <?php
        $result = $pdo->query('SELECT id,stage FROM stages');
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<button class="btn btn-secondary m-1" type="button" data-toggle="collapse" data-target="#multiCollapseExample'.$row['id'].'" aria-expanded="true" aria-controls="multiCollapseExample'.$row['id'].'" onclick="closeItems()">'.$row['stage'].'</button>';
        }
      ?>
      </section>

      <!--Наполнение разделов-->
      <section class="mb-2">
      <?php
        $result = $pdo->query('SELECT * FROM stages');
        $counter=0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<section class="multi-collapse collapse';
            if ($counter==0) {
                echo " show";
            };
            echo '" id="multiCollapseExample'.$row['id'].'">
            <section class="m-1 mb-3 p-1 font-weight-bold">
              '.$row['stage_description'].'
            </section>
              <ul class="list-unstyled">';
            $items = $pdo->query('SELECT * FROM '.$row['stage_table_name']);
            while ($item = $items->fetch(PDO::FETCH_ASSOC)) {
                echo  '<li class="card mb-1">
                    <div class="card-body p-2"  stage_table_name="'.$row['stage_table_name'].'" id="'.$item['id'].'">
                  <h5 class="card-title">'.$item['name'].'</h5>
                  <p class="card-text">'.mb_substr($item['description'], 0, 200).'...</p>
                  <section class="full_text" hidden="true">'.$item['name'].'<br>
'.$item['description'].'


</section>
                  <a href="card.php?stage='.$row['stage_table_name'].'&id='.$item['id'].'" class="card-link" target="_blank">Подробнее</a>
                  <a id="add_rem" class="card-link" onclick="appendToList(this.parentNode.parentNode.innerHTML);">Добавить в список</a>
              </div>
                  </li>';
            };
            echo  '</ul>
          </section>';
            $counter++;
        }
      ?>
      </section>

    </section>



        <div class="col-md-6" id="lesson_list">
        <h2>План урока</h2>
          <ul class="js-sortable sortable list flex flex-column list-reset list-unstyled">

          </ul>
          <section class="d-flex justify-content-end">
            <button id="save_btn" class="btn btn-secondary" onclick="saveDoc();" hidden>Скачать</button>
          </section>
        </div>

    </section>

    <section class="container">
      <hr class="featurette-divider m-5">
    </section>


    <footer class="container pb-5">
      <p class="float-right"><a href="#">Back to top</a></p>
      <p>© 2017-2018 Some Company, Inc.</p>
    </footer>


    <!-- Optional JavaScript -->
    <script type="text/javascript">
      function appendToList(html){
        var uls = document.getElementById('lesson_list').querySelectorAll('ul');
        var newli = document.createElement("li");
        newli.setAttribute("class", "card mb-1 bg-light");
        newli.setAttribute("draggable", "true");
        newli.setAttribute("role", "option");
        newli.setAttribute("aria-grabbed", "false");
        newli.innerHTML = html;
        var add_rem = newli.querySelector('#add_rem');
        add_rem.text = "Удалить из списка";
        add_rem.setAttribute("onclick", "this.parentNode.parentNode.remove();checkDownlBtn();");
        uls[0].appendChild(newli);
        document.querySelector('#save_btn').removeAttribute("hidden");
      }
    </script>

    <script type="text/javascript">
      sortable('.js-sortable', {
        forcePlaceholderSize: true,
        placeholderClass: 'mb1 border',
        hoverClass: '',
        itemSerializer: function (item, container) {
          item.parent = '[parentNode]'
          item.node = '[Node]'
          item.html = item.html.replace('<','&lt;')
                return item
        },
        containerSerializer: function (container) {
          container.node = '[Node]'
          return container
        }
      })
    </script>

    <script type="text/javascript">
        function closeItems() {
          var items = document.querySelectorAll("[id*='multiCollapseExample']");
          for (i = 0; i < items.length; ++i) {
            items[i].classList.remove('show');
          }
        }
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
      function saveDoc(){
        var a = document.createElement("a");
        var text = $(document.querySelectorAll('#lesson_list > ul > li > .card-body > .full_text')).text();
        a.setAttribute("href", "data:text/plain;charset=utf-8," + text);
        a.setAttribute("download", "lesson_list.doc");
        a.click();
      }

      function checkDownlBtn(){
        var cards = $(document.querySelectorAll('#lesson_list > ul > li > .card-body'));
        if (!cards.length){
          document.getElementById('save_btn').setAttribute("hidden", true);
        }
      }
  </script>
  </body>
</html>
